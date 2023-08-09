<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'SISGP',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>SISGP</b>',

    'logo_mini' => '<b>SIS</b>GP',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => 'fixed',

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */
    
    'menu' => [
        [
            'header' => 'IDENTIFICAÇÃO',
            'can' => 'IDENTIFICAR_PM',
        ],
        [
            'text'        => 'Dashboard RG',
            'url'         => 'rh/rg/dashboard',
            'icon'        => 'credit-card',
            'can'         => 'IDENTIFICAR_PM'
        ],
        [
            'text'        => 'Pesquisar RG',
            'url'         => 'rh/rg/pesquisa',
            'icon'        => 'search',
            'can'         => 'EMITIR_RG',
        ],
        [
            'text'        => 'Atendimentos',
            'url'         => 'rh/rg/atendimentos',
            'icon'        => 'calendar',
            'can'         => 'EMITIR_RG',
        ],
        [
            'text'        => 'Configurações',
            'url'         => 'rh/rg/config',
            'icon'        => 'fa-fw fa-wrench',
            'can'         => 'IDENTIFICAR_PM',
        ],
       
        [
            'header' => 'RECURSOS HUMANOS',
            'can' => 'Relatorios_rh',
        ],
        [
            'text'        => 'Dashboard RH',
            'url'         => 'rh/dash',
            'icon'        => 'pie-chart',
            'can'         => 'DASHBOARD_RH',
        ],
        [
            'text'    => 'PRONTUÁRIOS',
            'icon'    => 'user',
            'can'         => 'Relatorios_rh',
            'submenu' => [
                [
                    'text' => 'PMs Ativos na unidade',
                    'url'  => '/rh/policiais/ativo',
                    'can'         => 'Relatorios_rh',
                ],
                [
                    'text' => 'PMs nas unidades subordinadas',
                    'url'  => '/rh/policiais/unidadesubordinada/ativo',
                    'can'         => 'Relatorios_rh',
                ],
                [
                    'text' => 'Efetivo Geral',
                    'url'  => '/rh/policiais/efetivogeral/listagem/ativo',
                    'can'         => 'LISTA_EFETIVO_GERAL',
                ],
            ],
        ],
        [
            'text'    => 'LISTAGENS',
            'icon'    => 'user',
            'can'         => 'Relatorios_rh',
            'submenu' => [
               
                [
                    'text' => 'Relatórios',
                    'url'  => '/rh/relatorios',
                    'can'  => 'Relatorios_rh',
                   
                ],
                [
                    'text' => 'Mapa Força',
                    'url'  => '/rh/mapaforca',
                    'can'  => 'Administra',
                   
                ],
                [
                    'text' => 'Sumário',
                    'url'  => '/rh/sumario',
                    'can'  => 'Relatorios_rh',
                   
                ],
                [
                    'text' => 'Classificador',
                    'url'  => '/rh/classificador',
                    'can'  => 'Relatorios_rh',
                    'icon' => 'fa-fw fa-sort-numeric-asc',
                    
                ],
                
                /* [
                    'text' => 'PMs por Idade',
                    'url'  => '/rh/servidor/idade',
                    'can'         => 'Relatorios_rh',
                    
                ],
                [
                    'text' => 'Aniversariantes',
                    'url'  => '/rh/servidor/aniversarios/listagem',
                    'can'         => 'Relatorios_rh',
                ],
                [
                    'text' => 'Quadro Funcional',
                    'url'  => 'rh/servidor/sumario',
                    'can'         => 'Sumario',
                ],
                [
                    'text' => 'Licenças Finalizando',
                    'url'  => 'home',
                    'can'         => 'Edita_rh',
                ], */
            ],
        ],
        [
            'text'        => 'FÉRIAS',
            'url'         => 'admin/pages',
            'icon'        => 'plane',
            'can'         => 'Relatorios_rh',
            'submenu' => [
                [
                    'text' => 'Lista de férias',
                    'url'  => 'rh/relatorios/ferias/unidade',
                ],
                [
                    'text' => 'Plano de férias',
                    'url'  => 'rh/planoferias',
                    'icon' => 'fa-fw fa-list-ul',
                    'can'  => 'Relatorios_rh',
                ],
               
               
            ],
        ],
        [
            'text'        => 'LICENÇAS',
            'url'         => 'admin/pages',
            'icon'        => 'file',
            'can'         => 'Relatorios_rh',
            'submenu' => [
               /* [
                    'text' => 'Lista de Licenças',
                    'url'  => 'rh/relatorios/licencas/unidade/paginado',
                   
                ],*/
                [
                    'text'    => 'Listar Ativas',
                    'url'     => 'rh/licencasativas/listagem',
                    
                ],
                
            ],
        ],
        [
            'text'        => 'CURSOS',
            'url'         => 'admin/pages',
            'icon'        => 'file',
            'can'         => 'Relatorios_rh',
            'submenu' => [
                [
                    'text' => 'Lista curso',
                    'url'  => 'rh/relatorios/cursos/unidade/paginado',
                   
                ],
               
                
            ],
        ],
        [
            'text'        => 'OPÇÃO RELIGIOSA',
            'url'         => 'admin/pages',
            'icon'        => 'file',
           
            'submenu' => [
                [
                    'text' => 'Informar Opção Religiosa',
                    'url'  => 'rh/religiao/censo',                   
                ],
                [
                    'text' => 'EFETIVO GERAL COM INF. RELIGIOSA',
                    'url'  => 'rh/religiao/listaPoliciais/censo/sim/todas',
                    'can'         => 'CENSO_RELIGIOSO',                   
                ],
                [
                    'text' => 'EFETIVO GERAL SEM INF. RELIGIOSA',
                    'url'  => 'rh/religiao/listaPoliciais/censo/nao/todas',
                    'can'         => 'CENSO_RELIGIOSO',                   
                ],
                [
                    'text' => 'PMs COM INF. RELIGIOSA (Unidades)',
                    'url'  => 'rh/religiao/listaPoliciais/censo/sim/filhas',
                    'can'         => 'Edita_rh',                   
                ],
               
                [
                    'text' => 'PMs SEM INF. RELIGIOSA (Unidades)',
                    'url'  => 'rh/religiao/listaPoliciais/censo/nao/filhas',
                    'can'         => 'Edita_rh',                   
                ],
                [
                    'text' => 'DASHBOARD',
                    'url'  => 'rh/censoreligioso/dashboard',
                    'can'         => 'CENSO_RELIGIOSO',                   
                ],
            ],
        ],
        [
            'text'        => 'Medalhas',
            'url'         => 'rh/relatorios/medalhas/unidade',
            'icon'        => 'trophy',
            'can'         => 'Relatorios_rh',
           
        ],
        [
            'text'        => 'Movimentações',
            'url'         => 'rh/policiais/movimentacoes/importa_excel',
            'icon'        => 'exchange',
            'can'         => 'MANUTENCAO_SISTEMA',
           
        ],
       
        [
            'header' => 'DAL',
            'can' => 'Controle_fardamento',
        ],
        [
            'text'        => 'Meus Fardamentos',
            'url'         => 'rh/policial/fardamentos/meus_fardamentos',
            'icon'        => 'black-tie',
            'can'         => 'ACESSAR_MEUS_DADOS',
        ],
      
        [
            'text'        => 'Recursos',
            'url'         => 'dal/recursos',
            'icon'        => 'archive',
            'can'         => 'Administra',
        ],
        [
            'text'        => 'Grade de Uniformes',
            'url'         => 'dal/fardamentos/quantitativo',
            'icon'        => 'list-alt',
            'can'         => 'Controle_fardamento',
        ], 
        [
            'text'        => 'Policiais sem Fardamento',
            'url'         => 'rh/policiais/sem/fardamentos',
            'icon'        => 'user-times',
            'can'         => 'Controle_fardamento',
        ], 

        
       
        [
            'header' => 'BOLETIM',
            'can' => 'Leitura',
        ],
        [
            'text'        => 'Consultar',
            'url'         => '/boletim/consulta',
            'icon'        => 'fa-fw fa-search',
            'can'         => 'Leitura',
        ],
        [
            'text'        => 'BG Prático',
            'url'         => 'boletim/bgpratico',
            'icon'        => 'binoculars',
            'can'         => 'Administra',
        ],
        [
            'text'        => 'Boletins',
            'url'         => '/boletim/lista_boletim_pendente',
            'icon'        => 'file',
            'can'         => 'elabora_boletim',
        ],
        [
            'text'        => 'Boletins (Assinar)',
            'url'         => '/boletim/bg_elaboracao',
            'icon'        => 'file',
            'can'         => 'elabora_bg',
        ],
        [
            'text'        => 'Notas para Boletim',
            'url'         => '/boletim/notas',
            'icon'        => 'file',
            'can'         => 'elabora_nota_boletim',
        ],
        [
            'text'        => 'Notas Recebidas',
            'url'         => '/boletim/notas/recebidas',
            'icon'        => 'envelope',
            'can'        => 'Administra',
        ],
        [
            'text'        => 'Notas Tramitadas',
            'url'         => '/boletim/notas/tramitadas',
            'icon'        => 'envelope',
            'can'        => 'Administra',
        ],
        [
            'text'        => 'Tópicos',
            'url'         => '/boletim/topicos/lista',
            'icon'        => 'sort-amount-asc',
            'can'        => 'elabora_bg',
        ],
        [
            'text'        => 'Integrador - Agendamentos',
            'url'         => '/boletim/integrador/agendamentos',
            'icon'        => 'hourglass-end',
            'can'        => 'elabora_boletim',
        ],
        [
            'text'        => 'Mover Boletins',
            'url'         => '/boletim/mover',
            'icon'        => 'exchange',
            'can'        => 'Administra',
        ],
        [
            'header' => 'PROMOÇÃO',
            'can'         => 'Lista_QA_aberto',
            
        ],
        [
            'text'        => 'Quadro de Vagas',
            'url'         => 'promocao/quantitativodevagas',
            'icon'        => 'file',
            /* 'can'         => 'ATUALIZAR_QUANTITATIVO_VAGAS', */
            'can'         => 'admin',
            
        ],
        [
            'text'        => 'Quadro de Acesso',
            'url'         => 'promocao/listadequadrodeacesso',
            'icon'        => 'file',
            'can'         => 'Lista_QA_aberto',
            
        ],
        [
            'header' => 'JPMS',
            'can'    => 'JPMS',
            
        ],
        [
            'text'        => 'Dashboard JPMS',
            'url'         => 'juntamedica/dash',
            'icon'        => 'pie-chart',
            'can'         => 'JPMS',
            
        ],
        [
            'text'        => 'Restrições',
            'url'         => 'juntamedica/restricoes',
            'icon'        => 'tags',
            'can'         => 'JPMS',
            
        ],
        [
            'text'        => 'Sessões',
            'url'         => 'juntamedica/sessoes',
            'icon'        => 'hourglass-end',
            'can'         => 'JPMS',
            
        ],
        [
            'text'        => 'Prontuários',
            'url'         => 'juntamedica/prontuario',
            'icon'        => 'folder-open',
            'can'         => 'JPMS',
            
        ],
        [
            'text'        => 'Atendimentos Abertos',
            'url'         => 'juntamedica/atendimentosabertos',
            'icon'        => 'calendar-check-o',
            'can'         => 'JPMS',
            
        ],
        [
            'text'        => 'Relatório Atendimentos',
            'url'         => 'juntamedica/relatorio/atendimentos',
            'icon'        => 'calendar-check-o',
            'can'         => 'JPMS',
            
        ],
        [
            'header' => 'CMAPM',
            'can'         => 'CMAPM',
            
        ],
        [
            'text'        => 'Policiais em acompanhamento',
            'url'         => 'juntamedica/relatorioacompanhamentojpms',
            'icon'        => 'file-text-o',
            'can'         => 'CMAPM',
            
        ],
        
        [
            'text'        => 'INSPEÇÃO PROMOÇÃO',
            'url'         => 'promocao/listadequadrodeacesso/competencia/JPMS',
            'icon'        => 'file',
            'can'         => 'Administra',
            
            
        ],
        [
            'text'        => 'Atendimentos',
            'url'         => 'juntamedica/atendimentos/show',
            'icon'        => 'hospital-o',
            'can'         => 'Administra',
            
        ],
        [
            'text'        => 'Aguardando publicação (BG)',
            'url'         => 'juntamedica/aguardandoPublicacao/show',
            'icon'        => 'hourglass-half',
            'can'         => 'Administra',
            
        ],
        [
            'text'        => 'Policiais em Acompanhamento',
            'url'         => 'juntamedica/pendenciaMedica',
            'icon'        => 'user-md',
            'can'         => 'Administra',
            
        ],
        [
            'header' => 'DASHBOARD',
            'can'         => 'Administra',
            
        ],
        [
            'text'        => 'Efetivo',
            'url'         => 'dashboard',
            'icon'        => 'file',
            'can'         => 'Administra',
            
        ],
        [
            'header' => 'ADMINISTRAÇÃO',
            'can'         => 'Leitura',
            
        ],
        [
            'text'        => 'Usuários',
            'url'         => 'admin/usuarios',
            'icon'        => 'users',
            'can'         => 'Administrador',
            
        ],
        [
            'text'        => 'Perfis',
            'url'         => 'admin/perfis',
            'icon'        => 'unlock-alt',
            'can'         => 'Administrador',
            
        ],
        [
            'text'        => 'Perfis do efetivo',
            'url'         => 'rh/policiais/unidade/perfis/listagem',
            'icon'        => 'unlock-alt',
            'can'         => 'Administra',
            
        ],
        [
            'text'        => 'Permissões',
            'url'         => 'admin/permissions',
            'icon'        => 'key',
            'can'         => 'Administrador',
            
        ],
        [
            'text'        => 'Unidades',
            'url'         => 'admin/unidades',
            'icon'        => 'bank',
            'can'         => 'Leitura',
            
        ],
        [
            'header' => 'ORGANOGRAMA',
            'can'         => 'Leitura',
            
        ],
        [
            'text'        => 'Organograma',
            'url'         => 'admin/unidade/organograma/tipo/a',
            'icon'        => 'sitemap',
            'target'      => '_blank',
            'can'      => 'Leitura',
        ],
        
        [
            'text'        => 'Novo Organograma',
            'url'         => 'admin/unidade/organograma/tipo/n',
            'icon'        => 'sitemap',
            'target'      => '_blank',
            'can'         => 'MENU_NOVO_ORGANOGRAMA',
            
        ],
        [

            'header' => 'NOTÍCIAS',
               'can'         => 'Administrador',
           
        ],
        [
            'text'        => 'Notícias',
            'url'         => 'admin/noticias',
            'icon'        => 'bullhorn',
            'can'         => 'Administrador',
            
        ],
        [

            'header' => 'COMISSÃO TAF',
               'can'         => 'Administra',
           
        ],
        [
            'text'        => 'INSPEÇÃO PROMOÇÃO',
            'url'         => 'promocao/listadequadrodeacesso/competencia/TAF',
            'icon'        => 'file',
            'can'         => 'Administra',
            
        ],
              
        [
            'header' => 'CDO',
            'can'         => 'AUDITORIA_CDO',
            
        ],
        [
            'text'        => 'Auditoria',
            'url'         => 'rh/diarias/listapoliciaisferais',
            'icon'        => 'User',
            'can'         => 'AUDITORIA_CDO',
            
        ],              
        [
            'header' => 'DPS',
            'can'         => 'DASHBOARD_DPS',
            
        ],
        [
            'text'        => 'Dashboard DPS',
            'url'         => 'dps/dash',
            'icon'        => 'pie-chart',
            'can'         => 'DASHBOARD_DPS',
            
        ],
        [
            'text'        => 'Habilitações',
            'url'         => 'dps/habilitacoes',
            'icon'        => 'sign-in',
            'can'         => 'DASHBOARD_DPS',
            
        ],
        [
            'text'        => 'Pensões',
            'url'         => 'dps/pensionistas',
            'icon'        => 'user',
            'can'         => 'DASHBOARD_DPS',
            
        ],
        [
            'text'    => 'LISTAGENS',
            'icon'    => 'user',
            'can'         => 'DASHBOARD_DPS',
            'submenu' => [
               
                [
                    'text' => 'Relatórios',
                    'url'  => '/dps/relatorios',
                    'can'  => 'DASHBOARD_DPS',
                   
                ],
                [
                    'text'    => 'PMs Inativos',
                     'url'     => '/rh/policiais/inativo',
                     'can'         => 'Relatorios_rh',
                ],
            ],
        ],
        [
            'header' => 'DJD',
            'can' => 'PROCEDIMENTOS_INSTAURADOS'
        ],
        [
            'text'        => 'Dashboard DJD',
            'url'         => 'djd/dash',
            'icon'        => 'pie-chart',
            'can'         => 'PROCEDIMENTOS_INSTAURADOS'
        ],
        [
            'text'        => 'Procedimentos',
            'url'         => 'djd/procedimentos',
            'icon'        => 'balance-scale',
            'can'         => 'PROCEDIMENTOS_INSTAURADOS'
        ],

        
        [
            'header' => 'SOBRE',
            'can' => 'Leitura'
        ],
        [
            'text'        => 'Atualização',
            'url'         => 'admin/sobre',
            'icon'        => 'fa-fw fa-retweet',
            'can' => 'Leitura'
        ],
        
       
              

       /*  [

            'header' => 'CADASTROS',
               'can'         => 'Administrador',
           
        ],
        [
            'text'        => 'Órgãos',
            'url'         => 'rh/orgaos/listagem',
            'icon'        => 'file',
            'can'         => 'Administrador',
            
        ],
        [
            'text'        => 'Setores',
            'url'         => 'rh/setores/listagem',
            'icon'        => 'file',
            'can'  => 'Administrador',
        ],
        [
            'text'        => 'Unidades',
            'url'         => 'rh/unidades/listagem',
            'icon'        => 'file',
            'can'  => 'Administrador',
        ],
        [
            'text'        => 'Funções',
            'url'         => 'rh/funcoes',
            'icon'        => 'file',
            'can'  => 'Administrador',
        ],
        [
            'text'        => 'Status de Funções',
            'url'         => 'rh/statusfuncoes',
            'icon'        => 'file',
            'can'  => 'Administrador',
        ],
        [
            'text' => 'Cargos',
            'url'  => 'rh/cargos',
            'icon' => 'file',
            'can'         => 'Administrador',
            
        ],
        
         
       
        [

            'header' => 'ADMINISTRAÇÃO',
               'can'         => 'Administrador',
           
        ],
       
        [
            'text'    => 'Usuarios',
            'icon'    => 'user',
            'url'  => '/admin/usuarios',
            'can'         => 'Administrador',
        ],
        [
            'text' => 'Gratificações',
            'url'  => 'rh/gratificacoes/listagem',
            'icon' => 'money',
            'can'         => 'Administrador',
        ],
        
        [

            'header' => 'GESTÃO',
               'can'         => 'Administra',
           
        ],
      
        [
            'text' => 'Tipo de Registro',
            'url'  => 'rh/tiporegistros',
            'icon' => 'file',
            'can'         => 'Admin',
            
        ],
        [
            'text' => 'Tipo de Itens',
            'url'  => 'rh/tipoitens',
            'icon' => 'lock',
            'can'         => 'Admin',
        ],
        [
            'text' => 'Itens',
            'url'  => 'rh/itens',
            'icon' => 'file',
            'can'         => 'Admin',
        ],
        [
            'text'    => 'Usuarios',
            'icon'    => 'user',
            'can'         => 'Admin',
            'submenu' => [
                
                [
                    'text' => 'Perfil',
                    'url'  => 'admin/roles',
                    'can'         => 'Admin',
                ],
                [
                    'text' => 'Permissões',
                    'url'  => 'admin/permissions',
                    'can'         => 'Admin',
                ],
                
            ],
        ],
        
       
        [
            'text' => 'Change Password',
            'url'  => 'admin/settings',
            'icon' => 'lock',
        ],
        [
            'text'    => 'Multilevel',
            'icon'    => 'share',
            'submenu' => [
                [
                    'text' => 'Level One',
                    'url'  => '#',
                ],
                [
                    'text'    => 'Level One',
                    'url'     => '#',
                    'submenu' => [
                        [
                            'text' => 'Level Two',
                            'url'  => '#',
                        ],
                        [
                            'text'    => 'Level Two',
                            'url'     => '#',
                            'submenu' => [
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                ],
                                [
                                    'text' => 'Level Three',
                                    'url'  => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'Level One',
                    'url'  => '#',
                ],
            ],
        ],
        'LABELS',
        [
            'text'       => 'Important',
            'icon_color' => 'red',
        ],
        [
            'text'       => 'Warning',
            'icon_color' => 'yellow',
        ],
        [
            'text'       => 'Information',
            'icon_color' => 'aqua',
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
