@php $contador = 0; @endphp

                <table width="100%" border="1px" >
                    <thead>
                   
                        <tr>
                           <th colspan = "7">LISTA DE POLICIAIS</th>
                        </tr>
                        <tr>
                            <th >ORD</th>
                            <th >POST/ GRAD</th>
                            <th >NOME</th>
                            <th>MATRÍCULA</th>
                            <th >CPF</th>
                            <th >UNIDADE</th>
                            <th >PERFIL</th>
                           
                        </tr>
                    </thead>
                    <tbody>

                        @if(isset($policiais))
                            @forelse($policiais as $p)
                            @php $contador++ @endphp
                            <tr>
                                <td>{{$contador}}</td>
                                <td>{{$p->st_postograduacaosigla}}</td>
                                <td>{{$p->st_nome}}</td>
                                <td>{{$p->st_matricula}}</td>
                                <td>{{$p->st_cpf}}</td>
                                <td>{{$p->st_unidade}}</td>
                                <td>
                                @php $contadorPerfil = 0; @endphp
                                    @if(!empty($p->st_perfil)) 
                                   
                                    @foreach($p->st_perfil->roles as $perfil)
                                    @php $contadorPerfil++ @endphp
                                    {{$perfil->st_nome}}@if($contadorPerfil < count($p->st_perfil->roles)),@endif 
                                    @endforeach
                                    @endif

                                </td>
                              
                          
                            
                            </tr>
                        
                            @empty
                            <tr>
                                <td colspan="11" style="text-align: center;">Nenhum policial encontrado.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
