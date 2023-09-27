"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const vitest_1 = require("vitest");
const mensagensController_1 = require("@/Mensagens/Controllers/mensagensController");
const ApiRequest_1 = require("@/Utils/ApiRequest");
const mensagensController = new mensagensController_1.MensagensController;
const apiRequest = new ApiRequest_1.ApiRequest;
(0, vitest_1.test)('getDadosMensagensLivros', () => {
    const retorno = mensagensController.getDadosMensagensLivros(1);
    (0, vitest_1.expect)(retorno.livros_id).toBe(1);
    (0, vitest_1.expect)(retorno['Content-Type']).toBe('application/json');
    (0, vitest_1.expect)(retorno['Authorization']).toBe('Bearer ');
    (0, vitest_1.expect)(retorno['Accept']).toBe('application/json');
    (0, vitest_1.expect)(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    (0, vitest_1.expect)(retorno['Connection']).toBe('keep-alive');
});
(0, vitest_1.test)('getDadosAdicionarLivros', () => {
    const dados = {
        id: null,
        mensagem: 'TestCaseFrontEnd GetPost',
        livros_id: 1,
        meuperfil_id: 1,
    };
    const retorno = mensagensController.getPostMensagensLivros(dados);
    (0, vitest_1.expect)(retorno.id).toBeNull();
    (0, vitest_1.expect)(retorno.livros_id).toBe(1);
    (0, vitest_1.expect)(retorno.mensagem).toBe('TestCaseFrontEnd GetPost');
    (0, vitest_1.expect)(retorno.livros_id).toBe(1);
    (0, vitest_1.expect)(retorno.meuperfil_id).toBe(1);
    (0, vitest_1.expect)(retorno['Content-Type']).toBe('application/json');
    (0, vitest_1.expect)(retorno['Authorization']).toBe('Bearer ');
    (0, vitest_1.expect)(retorno['Accept']).toBe('application/json');
    (0, vitest_1.expect)(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    (0, vitest_1.expect)(retorno['Connection']).toBe('keep-alive');
});
(0, vitest_1.test)('getDadosDeletarMensagens', () => {
    const dados = {
        id: 1,
        meuperfil_id: 1,
        meuperfilamigo_id: 2,
    };
    const retorno = mensagensController.getDadosDeletarMensagens(dados);
    (0, vitest_1.expect)(retorno.id).toBe(1);
    (0, vitest_1.expect)(retorno.meuperfil_id).toBe(1);
    (0, vitest_1.expect)(retorno.meuperfilamigo_id).toBe(2);
    (0, vitest_1.expect)(retorno['Content-Type']).toBe('application/json');
    (0, vitest_1.expect)(retorno['Authorization']).toBe('Bearer ');
    (0, vitest_1.expect)(retorno['Accept']).toBe('application/json');
    (0, vitest_1.expect)(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    (0, vitest_1.expect)(retorno['Connection']).toBe('keep-alive');
});
