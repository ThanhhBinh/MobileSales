<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        // Xác thực các trường dữ liệu
        $request->validate(
            [
                'media_url.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Giới hạn loại file và kích thước
            ],
            [
                'media_url.*.required' => 'Hình ảnh là trường bắt buộc.',
                'media_url.*.image' => 'Hình ảnh phải là một hình ảnh.',
                'media_url.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
                'media_url.*.max' => 'Hình ảnh không được lớn hơn 2048 kilobytes.',
            ],
        );

        try {
            // Kiểm tra từng file hình ảnh
            foreach ($request->file('media_url') as $file) {
                // Nếu file không phải là hình ảnh, kiểm tra sẽ thất bại
                if (!$file->isValid() || !in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
                    return redirect()
                        ->back()
                        ->withErrors(['error' => 'Tệp tải lên không hợp lệ. Chỉ chấp nhận các tệp hình ảnh JPEG, PNG, JPG, GIF, và WEBP.']);
                }

                // Lưu file vào thư mục 'uploads'
                $path = $file->store('uploads', 'public');

                // Tạo bản ghi trong cơ sở dữ liệu
                Media::create([
                    'product_id' => $request->input('product_id'), // Lấy ID sản phẩm
                    'media_type' => 'image', // Loại media
                    'media_url' => $path, // Đường dẫn file
                ]);
            }

            // Trả về thông báo thành công
            return redirect()->back()->with('success', 'Hình ảnh đã được thêm thành công.');
        } catch (\Exception $e) {
            // Xử lý lỗi khác nếu có
            return redirect()
                ->back()
                ->withErrors(['error' => 'Đã xảy ra lỗi trong quá trình tải lên. Vui lòng thử lại.']);
        }
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'display_order' => 'required|integer',
            'media_type' => 'required|string',
        ]);

        // Cập nhật thông tin media
        $media = Media::findOrFail($id);
        $media->display_order = $request->input('display_order');
        $media->media_type = $request->input('media_type');
        $media->save();
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        $filePath = public_path('storage/' . $media->media_url);

        $media->delete();

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return response()->json(['success' => true]);
    }

    public function addVideo(Request $request)
    {
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'video_url' => 'required|url',
            'display_order' => 'required|integer',
            'product_id' => 'required|integer', // Thêm xác thực cho product_id
        ]);

        try {
            // Thêm video mới vào cơ sở dữ liệu
            $media = Media::create([
                'media_type' => 'video',
                'media_url' => $validatedData['video_url'],
                'display_order' => $validatedData['display_order'],
                'product_id' => $validatedData['product_id'], // Thêm product_id vào bản ghi
            ]);

            // Trả về JSON phản hồi cho frontend
            return response()->json([
                'success' => true,
                'id' => $media->id,
                'video_url' => $media->media_url,
                'display_order' => $media->display_order,
            ]);
        } catch (\Exception $e) {
            // Ghi lại lỗi vào log
            Log::error('Lỗi khi thêm video: ' . $e->getMessage());

            // Trả về thông báo lỗi
            return response()->json(
                [
                    'success' => false,
                    'error' => 'Đã xảy ra lỗi trong quá trình thêm video. Vui lòng thử lại.',
                    'details' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function updatevideo(Request $request, $id)
{
    // Xác thực dữ liệu
    $request->validate([
        'display_order' => 'required|integer',
        'media_url' => 'required|string',
    ]);

    // Cập nhật thông tin media
    try {
        $media = Media::findOrFail($id);
        $media->display_order = $request->input('display_order');
        $media->media_url = $request->input('media_url');
        $media->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        // Ghi log lỗi
        Log::error('Update video error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Cập nhật không thành công.'], 500);
    }
}

}
