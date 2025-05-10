<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function view_category()
    {
        $data=category::all();
        return view('admin.category',compact('data'));
    }

    public function add_category(Request $request)
    {
       $data=new category;

       $data->category_name=$request->category;

       $data -> save();

       return redirect()->back()->with('message', 'Categoría agregada exitosamente');


    }
    public function delete_category($id)
    {
        $data=category::find($id);
        $data->delete();

        return redirect()->back()->with('message', 'Categoría eliminada exitosamente');
    }
    public function view_producto()
    {
        $category=category::all();
        return view('admin.producto',compact('category'));
    }
    public function add_producto(Request $request)
    {
        $producto=new producto;

        $producto->title=$request->titulo;
        $producto->description=$request->description;
        $producto->price=$request->price;
        $producto->discount_price=$request->dis_price;
        $producto->quantity=$request->quantity;
        $producto->image=$request->image;
        $producto->category=$request->category;
        $image=$request->image;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('producto',$imagename);
        $producto->image=$imagename;
        $producto -> save();

        return redirect()->back()->with('message', 'Automóvil agregado exitosamente');
    }
    public function show_autos()
    {
        $producto=producto::all();
        return view('admin.show_autos',compact('producto'));
    }
    public function delete_producto($id)
    {
        $data=producto::find($id);
        $data->delete();

        return redirect()->back()->with('message', 'Automóvil eliminado exitosamente');
    }
    public function update_producto($id)
    {
        $producto=producto::find($id);
        $category=category::all();
        return view('admin.update_producto',compact('producto','category'));
    }
    public function edit_producto(Request $request, $id)
    {
        $producto=producto::find($id);

        $producto->title=$request->titulo;
        $producto->description=$request->description;
        $producto->price=$request->price;
        $producto->discount_price=$request->dis_price;
        $producto->quantity=$request->quantity;
        $producto->category=$request->category;

        if($request->hasFile('image'))
        {
            $image=$request->image;
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('producto',$imagename);
            $producto->image=$imagename;
        }

        $producto -> save();

        return redirect()->back()->with('message', 'Automóvil actualizado exitosamente');
    }
   
    public function admin_citas()
    {
        $citas = DB::table('citas')->get();

        // Agrupar citas por name, email, fecha y hora
        $agrupadas = $citas->groupBy(function ($item) {
            return $item->name . '|' . $item->email . '|' . $item->fecha . '|' . $item->hora;
        });

        $citasFinal = $agrupadas->map(function ($grupo) {
            return [
                'name' => $grupo[0]->name,
                'email' => $grupo[0]->email,
                'fecha' => $grupo[0]->fecha,
                'hora' => $grupo[0]->hora,
                'total' => count($grupo),
                'carros' => $grupo->pluck('product_title')->unique()->toArray()
            ];
        });

        return view('admin.admin_citas', ['citas' => $citasFinal]);
    }


    // Eliminar todas las citas de la misma persona en esa fecha y hora
    public function admin_cancelar_cita($fecha, $hora)
    {
        DB::table('citas')->where('fecha', $fecha)->where('hora', $hora)->delete();

        return redirect()->back()->with('message', 'Citas canceladas exitosamente');
    }
}
