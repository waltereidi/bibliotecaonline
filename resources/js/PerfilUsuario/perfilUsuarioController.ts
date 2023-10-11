export  class PerfilUsuarioController
{
    private token_aplicacao : string ;
    constructor(token_aplicacao:string)
    {
        this.token_aplicacao = token_aplicacao;
    }

    getDadosPerfilUsuarioLivros(users_id:number , offset:number )
    {
        return '/api/perfilusuario/getPerfilUsuarioLivros/Bearer '+this.token_aplicacao+'/'+users_id+'/'+offset;

    }
    async getPerfilusuarioLivros(url:string)
    {
        await axios.get(url);
    }


}
