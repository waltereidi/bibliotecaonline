import { expect, test } from 'vitest';
import { PerfilUsuarioController } from '@/PerfilUsuario/perfilUsuarioController';

const perfilUsuarioController = new PerfilUsuarioController('');

test('getDadosPerfilUsuarioLivros' , () => {
    const offset = 0 ;
    const users_id = 0 ;
    const retorno = perfilUsuarioController.getDadosPerfilUsuarioLivros(users_id , offset );
    expect(retorno ).toBe('/api/perfilusuario/getPerfilUsuarioLivros/Bearer /0/0');


})
