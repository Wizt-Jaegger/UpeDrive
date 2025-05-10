<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Producto;
use App\Models\Cart;
use App\Models\Cita;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        $producto = Producto::paginate(6);
        return view('home.userpage', compact('producto'));
    }
    public function redirect(){
        $Usertype = Auth::user()->usertype;

        if($Usertype == '1'){
            return view('admin.home');
        }else{
            $producto = Producto::paginate(6);
            return view('home.userpage', compact('producto'));
        }   
    }
    public function producto_detalles($id){
        $producto = Producto::find($id);
        return view('home.producto_detalles', compact('producto'));
    }
    public function add_cart(Request $request, $id){
        if(Auth::id()){
            $user= Auth::user();
            $producto = Producto::find($id);
            $cart = new Cart;
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            $cart->product_title = $producto->title;
            $cart->quantity = $request->quantity;
            $cart->price = $producto->price * $request->quantity;
            $cart->image = $producto->image;
            $cart->Product_id = $producto->id;
            $cart->user_id = $user->id;
            $cart->save();
            return redirect()->back()->with('message', 'Producto agregado al carrito');
        }else{
            return redirect('login');
        }
    }
    public function show_cart(){
        if(Auth::id()){
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->get();
            return view('home.show_cart', compact('cart'));
        }else{
            return redirect('login');
        }
    }
    public function remove_cart($id){
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back()->with('message', 'Producto eliminado del carrito');
    }
    public function agendar_cita(Request $request)
    {
        $user = Auth::user();
        $userid = $user->id;
        $data = Cart::where('user_id', $userid)->get();

        $fecha = $request->query('fecha');
        $tipo = $request->query('tipo');
        $hora = $request->query('hora');

        if (!$fecha || !$tipo) {
            return redirect()->back()->with('message', 'Faltan datos para agendar la cita.');
        }

        foreach ($data as $item) {
            $cita = new Cita;
            $cita->name = $user->name;
            $cita->email = $user->email;
            $cita->phone = $user->phone;
            $cita->address = $user->address;
            $cita->product_title = $item->product_title;
            $cita->quantity = $item->quantity;
            $cita->price = $item->price;
            $cita->image = $item->image;
            $cita->Product_id = $item->Product_id;
            $cita->user_id = $user->id;
            $cita->tipoCita = $tipo;
            $cita->fecha = $fecha;

            if ($hora) {
                $cita->hora = $hora;
            }

            $cita->save(); // ✔️ guardas correctamente
        }

        Cart::where('user_id', $userid)->delete();

        return redirect()->back()->with('message', 'Cita agendada con éxito.');
    }

    public function horasDisponibles(Request $request)
    {
        $fecha = $request->query('fecha');

        if (!$fecha) {
            return response()->json(['error' => 'Fecha no proporcionada'], 400);
        }

        $horasOcupadas = Cita::where('fecha', $fecha)->pluck('hora')->toArray();

        return response()->json([
            'ocupadas' => $horasOcupadas
        ]);
    }
    public function citas()
    {
        $userId = Auth::id();
        $citas = Cita::where('user_id', $userId)
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get()
                    ->groupBy(function ($cita) {
                        return $cita->fecha . ' ' . $cita->hora;
                    });

        return view('home.citas', compact('citas'));
    }
    public function cancelarCita($fecha, $hora)
    {
        $userId = Auth::id();
        $citas = Cita::where('user_id', $userId)->where('fecha', $fecha)->where('hora', $hora)->get();

        $fechaHoraCita = Carbon::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora);
        $horaActual = Carbon::now();

        

        if ($fechaHoraCita->greaterThan($horaActual) && $horaActual->diffInHours($fechaHoraCita) >= 1) {
            
            foreach ($citas as $cita) {
                $cita->delete();
            }
            return redirect()->back()->with('message', 'Cita cancelada correctamente');
        }

        return redirect()->back()->with('message', 'No se puede cancelar esta cita');
    }

    
}
