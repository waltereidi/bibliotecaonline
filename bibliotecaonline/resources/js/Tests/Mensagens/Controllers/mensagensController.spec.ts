import { expect, test } from 'vitest'
import { MensagensController } from "@/Mensagens/Controllers/mensagensController";
import axios  from 'axios';
import { ApiRequest } from '@/Utils/apiRequest';
import { MensagensCaixa } from '@/Mensagens/Entidades/mensagensCaixa';
import { Mensagens } from '@/Mensagens/Entidades/mensagens';

const mensagensController = new MensagensController;
const apiRequest = new ApiRequest;

test('getDadosMensagensLivros', () => {
    const retorno: object = mensagensController.getDadosMensagensLivros(1);

    expect(retorno.livros_id).toBe(1);
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');
});

test('getDadosAdicionarLivros', () => {
    const dados: object = {
        id: null,
        mensagem: 'TestCaseFrontEnd GetPost',
        livros_id: 1,
        meuperfil_id: 1,
    };

    const retorno: object = mensagensController.getPostMensagensLivros(dados);
    expect(retorno.id).toBeNull();
    expect(retorno.livros_id).toBe(1);
    expect(retorno.mensagem).toBe('TestCaseFrontEnd GetPost');
    expect(retorno.livros_id).toBe(1);
    expect(retorno.meuperfil_id).toBe(1);
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');
});

test('getDadosDeletarMensagens', () => {
    const dados: object = {
        id: 1,
        meuperfil_id: 1,
        meuperfilamigo_id: 2,
    };
    const retorno = mensagensController.getDadosDeletarMensagens(dados);
    expect(retorno.id).toBe(1);
    expect(retorno.meuperfil_id).toBe(1);
    expect(retorno.meuperfilamigo_id).toBe(2);
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');
});

