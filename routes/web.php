<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;

use App\Models\Produtos;
use App\Models\produtos_fixos;
use App\Models\Events;
use App\Http\Controllers\BotManController;

use App\Mail\SendMailUser;
use App\Models\historico_contact;
use App\Mail\EnvioMail;
use App\Http\Controllers\ContactController;
use PharIo\Manifest\Email;
use Illuminate\Routing\UrlGenerator;


Route::get('/', function () {
    return view('index');
});

Route::match(['get', 'post'], 'botman', [BotManController::class, "handle"]);

Route::get('/config_pacote', function () {

    $produtos = Produtos::all();
    
    return view('config_pacote',[
        'produtos' => $produtos,
    ]);
});

Route::post('/config_pacote', function (Request $request) {

    $opcao = 0;

    $email = request('email');
    $nome = request('nome');
    $produtos = request('produtos');

    $data = array(
        'nome' => $nome,
        'produtos' => $produtos,
        'opcao' => $opcao
    );

    Mail::to($email)
        ->send(new SendMailUser($data));

    return redirect('/');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/contato', function () {
    return view('contact.index');
});

Route::post('/contato', function (Request $request) {

    $contato = new historico_contact;
    
    $contato->nome = $request->nome;
    $contato->email = $request->email;
    $contato->descricao = $request->mensagem;
    $contato->data_envio = date('Y-m-d');

    $contato -> save(); 

    $opcao = 1;

    $request->validate([
        'nome' => 'required',
        'email' => 'required|email',
        'mensagem' => 'required'
    ]);

    $data = array (
        'nome' => $request->nome,
        'email' => $request->email,
        'mensagem' => $request->mensagem,
        'opcao' => $opcao

    );

    Mail::to($request->email)
        ->send( new SendMailUser($data) );


    return back()->with('success', 'Obrigado por nos contactar');
    

    return back()
            ->with('success', 'Obrigado por nos contactar');
});

Route::get('/calendario', function(){
    return view('fullcalendar.calendario');
});
        
Route::get('/pacotes', function(){

    $produtos = Produtos::all();

    $personzlizados = produtos_fixos::all();

    return view('pacotes',[
        'produtos' => $produtos,
        'personalizados' => $personzlizados,
    ]);
});

Route::get('/calendario', function(){

    $events = Events::all();
    
    return view('fullcalendar.calendario',[
        'events'=> $events
    ]);
});

Route::post('/calendario', function(Request $request){
    $event = new Events;
    $formatStart = str_replace('/','-',$request->start);
    $transformStart =  strtotime($formatStart);
    $dateStart = date('Y-m-d h:i:s', $transformStart);
    $formatEnd = str_replace('/','-',$request->end);
    $transformEnd =  strtotime($formatEnd);
    $dateEnd = date('Y-m-d h:i:s', $transformEnd);
    $event->title = $request->title;
    $event->start = $dateStart;
    $event->end = $dateEnd;
    $event->color =  $request->color;
    $event->save();
    return back()->with('success', 'Evento cadastrado com sucesso');
});

Route::put('/calendario', function(Request $request){
    Events::findOrFail($request->deletar)->update($request->all());
    return back()->with('success', 'Evento editado com sucesso');
});

Route::delete('/calendario', function(Request $request){
    Events::findOrFail($request->deletar)->delete();
    return back()->with('success', 'Evento deletado com sucesso');
});

