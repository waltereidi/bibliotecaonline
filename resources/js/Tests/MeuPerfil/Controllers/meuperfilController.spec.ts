import { expect, test } from 'vitest'
import { MeuPerfilController } from "@/MeuPerfil/Controllers/meuperfilController";
import { axios } from 'axios';
import { ApiRequest } from '@/Utils/ApiRequest';
import { MeuPerfilDados } from '@/MeuPerfil/Entidades/meuperfilDados';
import { LivrosMeuPerfil } from '@/MeuPerfil/Entidades/livrosMeuperfil';

const a = 1 ;
const b = 2 ;

const meuperfilController = new MeuPerfilController;
const apiRequest = new ApiRequest;



test('somar', () => {
    const expected = meuperfilController.somar(a, b);

    expect(expected).toBe(3)
});

test('getDadosMeuPerfil', () => {
    const user: Users = apiRequest.getTestToken('testCase@email.com', 'testCase');
    const retorno: MeuPerfilDados = meuperfilController.getDadosMeuPerfil(user.api_token);
    expect(retorno.id).not.toBeNull();

});

test('getEditarMeuPerfil', () => {
    const dados: object = {
        id: 1,
        users_id: 1,
        introducao: 'nova intro',
        profile_picture: null,
        datanascimento: null,
    };
    const retorno: MeuPerfilDados = meuperfilController.getEditarMeuPerfil(dados);

    expect(retorno.id).toBe(1);
    expect(retorno.users_id).toBe(1);
    expect(retorno.introducao).toBe('nova intro');
    expect(retorno.profile_picture).toBeNull();
    expect(retorno.datanascimento).toBeNull();
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');
});

test('getPostLivros', () => {
    const dados: object = {
        id: 1 ,
        titulo: 'testCaseFrontEnd',
        descricao: null,
        visibilidade: 0,
        isbn: null,
        editoras_nome: 'TestCaseFrontEnd',
        autores_nome: 'TestCaseFrontEnd',
        capalivro: null,
        genero: null,
        idioma: null,
    };

    const retorno: LivrosMeuPerfil = meuperfilController.getPostLivros(dados);
    expect(retorno.id).toBe(1);
    expect(retorno.titulo).toBe('testCaseFrontEnd');
    expect(retorno.descricao).toBeNull();
    expect(retorno.visibilidade).toBe(0);
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');

});
