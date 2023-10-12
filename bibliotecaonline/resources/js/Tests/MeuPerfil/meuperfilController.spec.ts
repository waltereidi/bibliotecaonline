import { expect, test } from 'vitest'
import { MeuPerfilController } from "@/MeuPerfil/meuperfilController";
import { ApiRequest } from '@/Utils/apiRequest';
import { MeuPerfilDados } from '@/Entidades/meuperfilDados';
import { LivrosMeuPerfil } from '@/Entidades/livrosMeuperfil';

const meuperfilController = new MeuPerfilController('' , {'users_id':1});
const apiRequest = new ApiRequest;


test('getPutMeuPerfil', () => {
    const dados: object = {
        id: 1,
        introducao: 'nova intro',
        profile_picture: null,
        datanascimento: '1993-12-29',
    };
    const retorno: MeuPerfilDados = meuperfilController.getPutMeuPerfil(dados);

    expect(retorno.id).toBe(1);
    expect(retorno.users_id).toBe(1);
    expect(retorno.introducao).toBe('nova intro');
    expect(retorno.profile_picture).toBeNull();
    expect(retorno.datanascimento).toBe('29/12/1993');
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');
});

test('getDadosLivros', () => {
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
        urldownload: 'http://www.php.net',
    };

    const retorno: LivrosMeuPerfil = meuperfilController.getDadosLivros(dados);
        expect(retorno.id).toBe(1 );
        expect(retorno.titulo).toBe('testCaseFrontEnd');
        expect(retorno.descricao).toBe(null);
        expect(retorno.visibilidade).toBe(1);
        expect(retorno.isbn).toBe(null);
        expect(retorno.editoras_nome).toBe('TestCaseFrontEnd');
        expect(retorno.autores_nome).toBe('TestCaseFrontEnd');
        expect(retorno.capalivro).toBe(null);
        expect(retorno.genero).toBe(null);
        expect(retorno.idioma).toBe(null);
        expect(retorno.urldownload).toBe('http://www.php.net');
        expect(retorno.users_id).toBe(1);
        expect(retorno['Content-Type']).toBe('application/json');
        expect(retorno['Authorization']).toBe('Bearer ');
        expect(retorno['Accept']).toBe('application/json');
        expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
        expect(retorno['Connection']).toBe('keep-alive');
});

test('getDeletelivros' , () => {
    const id = 1 ;
    const retorno = meuperfilController.getDeleteLivros(id);
    expect(retorno).toBe('/api/meuperfil/deleteLivros/Bearer /1');


})

test('getDadosPostLivrosQuantidadeTotal' , () => {
    const users_id = 1 ;
    const retorno = meuperfilController.getDadosGetMeuPerfilLivrosDoUsuarioQuantidade(users_id);

    expect(retorno).toBe('/api/meuperfil/getMeuPerfilLivrosDoUsuarioQuantidade/Bearer /1');

})
