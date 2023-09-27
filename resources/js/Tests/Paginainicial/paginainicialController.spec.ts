import { expect, test } from 'vitest';
import { PaginainicialController } from "@/Paginainicial/paginainicialController";
import { PostIndicesPaginainicial } from '@/Entidades/postIndicesPaginainicial';

const paginainicialController = new PaginainicialController() ;

test('getDadosBuscaIndice' , () => {
    const iniciopagina = 0 ;
    const quantidade = 6 ;
    const busca = [{ indice : 'terror' , tipo : 'genero'} , {indice:'romance' , tipo:'editoras'}];
    const retorno :PostIndicesPaginainicial = paginainicialController.getDadosBuscaIndice(quantidade,iniciopagina ,busca );
    expect(retorno.iniciopagina).toBe(0);
    expect(retorno.busca.length).toBe(2);
    expect(retorno.quantidade).toBe(6);
    expect(retorno.busca[0].indice).toBe('terror');
});

test('getDadosBuscaIndiceRequest' , () => {
    const iniciopagina = 0 ;
    const quantidade = 6 ;
    const busca = [{ indice : 'terror' , tipo : 'genero'} , {indice:'romance' , tipo:'editoras'}];
    const retorno :PostIndicesPaginainicial = paginainicialController.getDadosBuscaIndice(quantidade,iniciopagina ,busca );
    const retornoDadosRequest = paginainicialController.getDadosBuscaIndiceRequest(retorno);
    expect(retornoDadosRequest.iniciopagina).toBe(0);
    expect(retornoDadosRequest.busca.length).toBe(2);
    expect(retornoDadosRequest.quantidade).toBe(6);
    expect(retornoDadosRequest.busca[0].indice).toBe('terror');
    expect(retornoDadosRequest['Content-Type']).toBe('application/json');
    expect(retornoDadosRequest['Authorization']).toBe('Bearer ');
    expect(retornoDadosRequest['Accept']).toBe('application/json');
    expect(retornoDadosRequest['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retornoDadosRequest['Connection']).toBe('keep-alive');
});

test('getDadosBuscaRequest' , () => {
    const busca = 'Livros';
    const retorno = paginainicialController.getDadosBuscaRequest(busca);
    expect(retorno['busca']).toBe(busca);
    expect(retorno['Content-Type']).toBe('application/json');
    expect(retorno['Authorization']).toBe('Bearer ');
    expect(retorno['Accept']).toBe('application/json');
    expect(retorno['Accept-Encoding']).toBe('gzip, deflate, br');
    expect(retorno['Connection']).toBe('keep-alive');
}) ;
