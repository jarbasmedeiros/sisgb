<?php

Route::prefix('dal')->group(function() {
    Route::get('/', 'DalController@index');
    
    
    //Rotas para os Recursos
    Route::get('/recursos', 'DalController@getRecursos');
    Route::post('/recursos/paginado', 'DalController@getRecursos');
    Route::post('/recursos/cadastrar','DalController@cadastraRecurso');
    Route::get('/recursos/edita/{idRecurso}','DalController@editaRecurso');
    Route::post('/recursos/edita/{idRecurso}','DalController@forEditaRecurso');
    Route::get('/recursos/excluirecurso/{idRecurso}','DalController@excluiRecurso');
    Route::delete('/recursos/excluirecurso/{idRecurso}','DalController@excluiRecurso');

    //Rotas para Fardamentos
    Route::get('/fardamentos/quantitativo','DalController@getQuantitativoFardamentos');
    Route::post('/fardamentos/quantitativo/{renderizacao}','DalController@getQuantitativoFardamentosPorUnidades');
    
});
