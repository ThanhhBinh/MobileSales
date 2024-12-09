<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderDetailRequest;
use App\Models\OrderDetail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrderDetailController extends Controller
{
    public function index()
    {
        $list=OrderDetail::orderBy('created_at','DESC')
        ->get();
        
        return view("backend.orderdetail.index",compact('list'));
    }

    public function show(string $id)
    {
        $orderdetail = OrderDetail::find($id);
        if ($orderdetail == null) {
            return redirect()->route('admin.orderdetail.index');
        }
        
        $order = Order::where('order_id', $orderdetail->order_id)
            ->where('status', '!=', 0)
            ->first(); 
        
        if ($order == null) {
            return redirect()->route('admin.orderdetail.index');
        }
        
        return view("backend.orderdetail.show", compact('orderdetail', 'order'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orderdetail = OrderDetail::find($id);
        if($orderdetail ==  null)
        {
            return redirect()->route('admin.orderdetail.index');
        }
        $list=OrderDetail::orderBy('created_at','DESC')
        ->get();

        return view("backend.orderdetail.edit",compact('list','orderdetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $orderdetail = OrderDetail::find($id);
        if ($orderdetail == null) {
            return redirect()->route('admin.orderdetail.index');
        }
        $orderdetail->quantity = $request->quantity;
        $orderdetail->amount = $request->amount;
        $orderdetail->price = $request->price;

        $orderdetail->save();

        return redirect()->route('admin.orderdetail.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $orderdetail = OrderDetail::find($id);
            if ($orderdetail == null) {
                return redirect()->route('admin.orderdetail.index');
            }
        $orderdetail->updated_at = date('Y-m-d H:i:s');
        $orderdetail->updated_by = Auth::id() ?? 1;
        $orderdetail->save();
        return redirect()->route('admin.orderdetail.index');
    }
    public function trash()
    {
        $list= OrderDetail::orderBy('created_at','DESC')
        ->get();
        return view("backend.orderdetail.trash",compact('list'));
    }
    public function destroy (string $id)
    {
        $orderdetail = OrderDetail::find($id);
        if ($orderdetail == null) {
        return redirect()->route('admin.orderdetail.index');
        }
        $orderdetail->delete();
        return redirect()->route('admin.orderdetail.trash');
    }
    public function restore(string $id)
    {
        $orderdetail = OrderDetail::find($id);
        if ($orderdetail == null) {
            return redirect()->route('admin.orderdetail.index');
        }
    $orderdetail->status = 2;
    $orderdetail->updated_at = date('Y-m-d H:i:s');
    $orderdetail->updated_by = Auth::id() ?? 1;
    $orderdetail->save();
    return redirect()->route('admin.orderdetail.index');
    }
}
