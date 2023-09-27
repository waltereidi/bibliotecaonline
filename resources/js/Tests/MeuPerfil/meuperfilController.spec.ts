import { expect, test } from 'vitest'
import { MeuPerfilController } from "@/MeuPerfil/meuperfilController";
import { ApiRequest } from '@/Utils/ApiRequest';
import { MeuPerfilDados } from '@/Entidades/meuperfilDados';
import { LivrosMeuPerfil } from '@/Entidades/livrosMeuperfil';

const meuperfilController = new MeuPerfilController();
const apiRequest = new ApiRequest;


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
    expect(retorno.mensagem).toBe();
    expect(retorno.livros_id).toBe();
    expect(retorno.meuperfil_id).toBe();
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');

});


