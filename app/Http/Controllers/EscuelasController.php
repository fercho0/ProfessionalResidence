<?php

namespace Residence\Http\Controllers;

use Illuminate\Http\Request;

use Residence\Http\Requests;
use Residence\Models\Escuela;
use Residence\Models\Director;
use Residence\Models\Direccion;
class EscuelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $escuelas =Escuela::join('directores','directores.id','=','escuelas.DI_id')->Select('*')->Buscador($request->nombre)->paginate(2);
        return View('admin.escuelas.index')->with('escuelas',$escuelas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.escuelas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  

        
        $director= new Director;
        $director->DI_nombre=($request->name);     
        $director->DI_apellido_p=($request->apellidop);
        $director->DI_apellido_m=($request->apellidom);
        $director->DI_correo=($request->correo);
        $director->save();
        $iddirector = Director::find($director->id);

        $direcciones=new Direccion;
        $direcciones->DIR_calle=($request->calle);
        $direcciones->DIR_numero=($request->numero);
        $direcciones->DIR_estado=($request->estado);
        $direcciones->DIR_ciudad=($request->ciudad);
        $direcciones->DIR_colonia=($request->colonia);
        $direcciones->DIR_cp=($request->cp);
        $direcciones->save();
        $iddireccion = Direccion::find($direcciones->id);

        
        $escuela= new Escuela;
        $escuela->ESC_nombre=($request->name);     
        $escuela->ESC_clave=($request->clave);
        $escuela->DIR_id=($iddireccion->id);
        $escuela->DI_id=($iddirector->id);
        $escuela->save();           
        
        flash('Escuela registrada correctamente', 'success')->important();
        return View('admin.escuelas.create');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        #dd("yo editare");
        $escuelas=Escuela::select('*')->where('id','=',$id)->get();

        foreach ($escuelas as $esc)
        {
            $iddir=$esc->DIR_id;
            $iddi=$esc->DI_id;
        }

    
        $escuelass=Escuela::find($id);
        $direccion=Direccion::find($iddir);
        $director=Director::find($iddi);

       return view('admin.escuelas.edit')
       ->with('escuelass', $escuelass)
       ->with('direccion', $direccion)
       ->with('director', $director);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $escuela= Escuela::find($id);
        $escuela ->ESC_nombre=$request->nombre;
        $escuela ->ESC_clave=$request->clave;
        #dd($escuelas);
        $escuela->save();

         
        $escuelas=Escuela::select('*')->where('id','=',$id)->get();

        foreach ($escuelas as $esc)
        {
            $iddir=$esc->DIR_id;
            $iddi=$esc->DI_id;
        }

    
        $escuelass=Escuela::find($id);
        $direccion=Direccion::find($iddir);
        $director=Director::find($iddi);
        flash('Escuela modificada correctamente :)', 'success')->important();

       return view('admin.escuelas.edit')
       ->with('escuelass', $escuelass)
       ->with('direccion', $direccion)
       ->with('director', $director);
    }

    public function updatedirectores(Request $request, $id)
    {
        

        $directores= Director::find($id);
        $directores->DI_nombre=$request->nombre;
        $directores->DI_apellido_p=$request->apellidop;
        $directores->DI_apellido_m=$request->apellidom;
        $directores->DI_correo=$request->correo;
        #dd($directores);
        $directores->save();

        flash('Datos de director actualizados correctamente', 'success')->important();
        return redirect()->route('admin.escuelas.index');
        
    }
    
    public function updatedirecciones(Request $request, $id)
    {
        $direcciones= Direccion::find($id);
        $direcciones->DIR_calle=$request->calle;
        $direcciones->DIR_numero=$request->numero;
        $direcciones->DIR_estado=$request->estado;
        $direcciones->DIR_ciudad=$request->ciudad;
        $direcciones->DIR_colonia=$request->colonia;
        $direcciones->DIR_cp=$request->cp;
        #dd($direcciones);
        $direcciones->save();

        flash('Drireccion de la escuela actualizada correctamente', 'success')->important();
        return redirect()->route('admin.escuelas.index');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
       


        $escuelas = Escuela::find($id);
        $iddirector=$escuelas->DI_id;
        $iddir=$escuelas->DIR_id;
        #dd($iddirector,$iddir);
        $director= Director::find($iddirector);
        $direccion=Direccion::find($iddir);


        $escuelas->delete();
        $director->delete();
        $direccion->delete();
        return redirect()->route('admin.escuelas.index');
    }
}











