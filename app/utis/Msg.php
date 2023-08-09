<?php

namespace App\Utis;


/**
 * Description of Enum Msg
 *
 * @author medeiros
 * @author falecomjazon@gmail.com
 * @date 26/11/2019
 */
final class Msg {
    const SALVO_SUCESSO = 'Salvo com sucesso.';
    const ATUALIZADO_SUCESSO = 'Atualizado com sucesso.';
    
    const ARQUIVO_NAO_E_IMAGEM = 'O arquivo deve ser uma imagem.';
    const ARQUIVO_NAO_ENCONTRADO = 'Arquivo não encontrado.';
    /** 
     * Mensagens de erros mapeadas 
     * */
    const TOKEN_INVALIDO = 'Token inválido.'; 
    const WEBTOKEN_INVALIDO = 'WebToken inválido.';
    
    const FALHA_BANCO = 'Falha ao salvar no banco de dados.';    
    const FALHA_CONEXAO = 'Falha de conexão com banco de dados.';    
    const FALHA_REQUISICAO = 'Falha da conexão com API.';    
    
    const NENHUM_RESULTADO_ENCONTRADO = 'Nenhum resultado encontrado.';
    const PARAMETRO_INVALIDOS = 'Parâmetro inválido.';
    const PARAMETRO_RENDERIZAÇÃO_INVALIDOS = 'Parâmetro de renderização inválido.';
    const CAMPOS_OBRIGATORIOS = 'Preencha o(s) campos obrigatório(s).';
    const QA_NAO_ENCONTRADO = 'Quadro de Acesso não encontrado.';//utliza quando verifica se existe um QA com o id passado como parâmetro para realizar alguma ação vinculada ao referido QA
    const CRONOGRAMA_NAO_ENCONTRADO = 'Cronograma não encontrado.';//utliza quando verifica se existe um cronograma para um QA com o id passado como parâmetro para realizar alguma ação vinculada ao Cronograda do QA
    const NAO_PERMITIDO = 'Ação não permitida!';
    
    const POLICIAL_NAO_ENCONTRADO = 'Polical não encontrado.';//utliza quando verifica se existe um policial com o id passado como parâmetro para realizar alguma ação vinculada ao referido policial
    const POLICIAL_SEM_UNIDADE = 'O policial sem vinculo com OPM.';
    const POLICIAL_REMOVIDO_DA_NOTA = 'O policial removido da nota com sucesso.';
    const ERRO_AO_REMOVER_POLICIAL_DA_NOTA = 'Polical não removido da nota.';
    const POLICIAL_NO_QA = 'Policial já vinculado ao QA.';//utliza quando verifica se existe um policial com o id passado como parâmetro para realizar alguma ação vinculada ao referido policial
    const POLICIAL_INEXISTENTE_NO_QA = 'Policial Não encontrado no QA Selecionado.';//utliza quando verifica se existe um policial com o id passado como parâmetro para realizar alguma ação vinculada ao referido policial
    // Utilizado quando é feito a consulta da ficha de reconhecimento do PM ou exibir o pdf
    const POLICIAL_SEM_PONTUACAO = 'Policial não possui pontuação na ficha de reconhecimento.';
    // Utilizado na lista dos PMs vinculados ao um Quadro de Acesso que realizaram o Taf
    const POLICIAL_NAO_INSPECIONADO = 'Não há policial inspecionado para este QA.';
    const POLICIAL_NAO_ENCONTRADO_NA_COMISSAO = 'Polical não encontrado na Comissão.';//utliza quando verifica se existe um policial cadastrado na comissão de uma ata ou portaria para assinatura.

    
    
    const ATIVIDADE_NAO_ENCONTRADA = 'Atividade não encontrada no Cronograma do QA.';//utliza quando verifica se existe uma atividade com o id passado como parâmetro para realizar alguma ação vinculada a referida atividade
    const ATIVIDADE_CONCLUIDA = 'Esta atividade já foi concluida.';//utliza quando verifica se existe uma atividade com o id passado como parâmetro para realizar alguma ação vinculada a referida atividade
    
    const EXCLUIDO_SUCESSO = 'Exclusão realizada com sucesso.';

    const PERMISSOES_DE_USUARIO_NAO_ENCONTRADAS = 'Nenhuma permissão de usuário encontrada.';
    const PERFIS_DE_USUARIO_NAO_ENCONTRADOS = 'Nenhum perfil de usuário encontrado.';
    const USUARIO_SEM_VINCULO_OBJETO = 'Usuário sem vinculo com a unidade do objeto';
    const USUARIO_SEM_PERMISSAO_PARA_ACAO = 'Usuário não tem permissão para efetuar esta alteração.';
    
    const NOTA_GERADA_COM_SUCESSO = 'Nota gerada com sucesso.';
    const NOTA_NAO_ENCONTRADA = 'Nota para boletim não encontrada.';
    const NOTA_ENVIADA_PARA_CORRECAO = 'Nota enviada para correção.';
    const NOTA_FINALIZADA ='Nota finalizada com sucesso.';
    const NOTA_ASSINADA ='Nota assinada com sucesso.';
    const NOTA_ENVIADA ='Nota enviada com sucesso.';
    const NOTA_NAO_ENVIADA ='Esta operação so é permitida para nota com status de enviada.';
    const ERRO_AO_ENVIAR_NOTA ='Não foi possível enviar a Nota.';
    const ERRO_AO_ASSINAR_NOTA ='Não foi possível assinar a Nota.';
    const ERRO_AO_FINALIZAR_NOTA ='Não foi possível finalizar a Nota.';
    const ERRO_ENVIAR_NOTA_A_CORRECAO = 'Erro ao enviar a nota para correção.';
    const NOTA_JA_EXISTE = 'Já existe uma Nota de Boletim para esta atividade.';
    const NOTA_NAO_DISPONIVEL = 'Nota não disponível para o boletim.';
    const NOTA_REMOVIDA = 'Nota removida do boletim.';
    const NOTA_CRIADA_COM_SUCESSO = 'Nota gerada com sucesso ao boletim.';
    const ERRO_AO_CRIAR_NOTA = 'Erro ao criar a nota.';
    const IMPOSSIVEL_REMOVER_NOTA = 'Não foi possível Remover a nota do Boletim.';
    const IMPOSSIVEL_ALTERAR_NOTA = 'Não foi possível alterar a nota do Boletim.';
    const IMPOSSIVEL_EDITAR_NOTA = 'Só é possível editar nota com os status de rascunho.';
    const NOTA_ALTERADA_COM_SUCESSO = 'Nota alterada com sucesso ao boletim.';
    const ATRIBUIR_NOTA = 'Informe a parte do boletim à atribuir a nota';
    const NOTA_ATRIBUIDA = 'Nota atribuida ao boletim';
    const ERRO_AO_ATRIBUIR_NOTA = 'Não foi possivel atribuir a nota ao boletim';
    
    const REGISTRO_NAO_ENCONTRADO = 'Registro não encontrado';


    const SENHA_OBRIGATORIA = 'Informe a Senha Usuário.';
    const SENHA_INVALIDA = 'Senha inválida.';

    const STATUS_INVALIDO = 'Não existe policiais com o status passado como parâmetro.';
     
    const ERRO_DESCONHECIDO = 'Ocorreu um erro desconhecido. Por favor, Tente novamente.'; 
    const ERRO_API = 'Serviço da API com erro.';
    const ERRO_API_NAO_ENCONTRADO = 'Serviço não encontrado na API.';
    const ERRO_SEQUENCIAL_NOTA = 'Ocorreu um erro ao gerar o número da nota para boletim.';
    const ERRO_LIMITE_REQUISICOES = 'Você excedeu o limite de requisições. Aguarde um momente e tente novamente.';
    
    const JSON_NAO_PAGINADO = 'Json da listagem não está paginado.';
    const JSON_INVALIDO = 'Formato do Json inválido.';

    const UNIDADE_NAO_ENCONTRADA = 'Unidade Operacional não encontrada.';
    
    const BOLETIM_NAO_ENCONTRADO = 'Boletim não Encontrado.';
    const BOLETIM_GERADO = 'Boletim gerado com sucesso.';
    const BOLETIM_JA_PUBLICADO = 'Este Boletim já foi publicado ou assinado.';
    const ERRO_AO_EXCLUIR_BOLETIM = 'Não foi possivel excluir boletim já publicado ou com notas atribuidas';
    const BOLETIM_EXCLUIDO = 'Boletim excluído com sucesso';
    const BOLETIM_ASSINADO = 'Boletim Assinado com sucesso.';
    const ERRO_ASSINAR_BOLETIM = 'Não foi possível Assinar o Boletim.';
    const BOLETIM_CONDICAO = 'O boletim só pode ser Publicado se estiver com status de Assinado.';
    const BOLETIM_PUBLICADO = 'Boletim publicado com sucesso.';
    const ERRO_PUBLICAR_BOLETIM = 'Não foi possível Publicar o Boletim.';
    const BOLETIM_DEVOLVIDO_CORRECAO = 'Boletim devolvido para correção.';
    const ERRO_DEVOLVER_BOLETIM = 'Não foi possível retornar o Boletim para elaboração.';
    const BOLETIM_N_ABERTO_FINALIZAR = 'Boletim precisa estar aberto para ser finalizado.';
    const BOLETIM_FINALIZADO = 'Boletim finalizado.';
    const BOLETIM_CAPA_NAO_ENCONTRADA = 'Capa de boletim não encontrada.';
    const ERRO_FINALIZAR_BOLETIM = 'Não foi possível finalizar o Boletim.';
    const ERRO_FINALIZAR_NOTA = 'Nota precisa estar com status de rascunho para ser finalizada.';
    const ERRO_ATUALIZAR_BOLETIM = 'Não foi possível atualizar a Boletim.';
    const ERRO_RECUSAR_NOTA = 'Não foi possível recusar a nota.';
    const ERRO_RECUSAR_STATUS = 'Só é possível resusar a nota se ela estiver com status de recebida ou enviada.';
    const ERRO_CRIAR_BOLETIM = 'Erro ao criar boletim.';
    const ERRO_EXCLUIR_NOTA = 'Erro ao Excluir Nota de Boletim';
    const ERRO_CORRIGIR_NOTA = 'Nota precisa estar com status de finalizada, recusada ou assinada para ser enviada para correção.';
    const NOTA_EXCLUIDA = 'Nota Excluída com sucesso.';
    const NOTA_RECUSADA = 'Nota recusada com sucesso.';
    const NOTA_ACEITA = 'Nota aceita com sucesso.';
    const ERRO_ACEITAR_NOTA = 'Erro ao aceitar a Nota de Boletim';
    const NOTA_NAO_RASCUNHO = 'Esta operação so é permita para nota com status rascunho.';
    const NOTA_NAO_ASSINADA = 'Esta operação so é permita para nota com status assinada.';
    
    const USUARIO_REMOVIDO = 'Usuário removido com sucesso.';
    const ERRO_REMOVER_USUARIO = 'Erro ao remover o usuário.';
    const USUARIO_CADASTRADO = 'Usuário cadastrado com sucesso.';
    const ERRO_CADASTRAR_USUARIO = 'Erro ao cadastrar o usuário.';
    const USUARIO_ALTERADO = 'Usuário salvo com sucesso.';
    const ERRO_ALTERAR_USUARIO = 'Erro ao salvar o usuário.';
    const USUARIO_NAO_ENCONTRADO = 'Usuário não encontrado.';
    const USUARIO_NAO_REMOVIDO = 'Erro ao remover o Usuário.';
    const USUARIO_DE_OUTRA_UNIDADE =  'Usuário não é vinculado a unidade do boletim.';
    const USUARIO_NAO_E_POLICIAL = 'Usuário logado não é um policial ativo no sistema.';
    const USUARIO_NAO_ATRIBUI_NOTA = 'Usuário não pode atribuir nota de outra unidade';

    const PERFIL_NAO_ENCONTRADO = 'Perfil de Usuário não encontrado';
    const ERRO_ATUALIZAR_PERFIL = 'Erro ao atualizar Perfil';

    const PERMISSAO_CADASTRADA = 'Permissão de Usuário cadastrada com sucesso';
    const ERRO_CADASTRAR_PERMISSAO = 'Erro ao cadastrar Permissão de Usuário';

    const CAPA_NAO_ENCONTRADA = 'Capa de boletim não encontrada.';
    const CAPA_ATUALIZADA = 'Capa atualizada com sucesso.';
    const CAPA_CRIADA = 'Capa de boletim criada com sucesso!';

    const HISTORICO_FERIAS_TIPO_ERRADO = 'Tipo de histórico de férias está errado.';
    const HISTORICO_LICENCA_TIPO_ERRADO = 'Tipo de histórico de licença está errado.';

}

?>