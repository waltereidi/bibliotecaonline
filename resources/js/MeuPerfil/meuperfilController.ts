import axios from "axios";
import { ApiRequest } from "@/Utils/apiRequest";
import { LivrosMeuPerfil } from "@/Entidades/livrosMeuperfil";
import { putMeuPerfil } from "@/Entidades/putMeuPerfil";
export class MeuPerfilController{
    public api_token: string;
    private apiRequest: ApiRequest;
    private headers: object;
    private meuperfil : object ;
    constructor(api_token: string , meuperfil:object ) {
        this.api_token = api_token;
        this.apiRequest = new ApiRequest;
        this.headers = this.apiRequest.getDefaultHeaders(this.api_token);
        this.meuperfil = meuperfil;
        console.log(meuperfil);
    }
    somar( a:number , b:number ) : number {
        return a+b ;
    }

    getPutMeuPerfil( dados :object):object {
        let dataFormatada= null;
        if( Date(dados.datanascimento) != 'Invalid Date' && dados.datanascimento !=='' )
        {
            const data = dados.datanascimento.split('-');
            dataFormatada = data[2]+'/'+data[1]+'/'+data[0] ;
        }
        return {
            id : dados.id ,
            users_id : this.meuperfil.users_id ,
            introducao : dados.introducao??null ,
            profile_picture : dados.profile_picture??null ,
            datanascimento :dataFormatada,
            ...this.headers
        }
    }

    getDadosLivros(dados:object): object{

        return {
            id: dados.id??null ,
            titulo: dados.titulo,
            descricao: dados.descricao??null,
            visibilidade: 1,
            isbn: dados.isbn??null,
            editoras_nome: dados.editoras_nome,
            autores_nome: dados.autores_nome,
            capalivro: dados.capalivro??null,
            genero: dados.genero??null,
            idioma: dados.idioma??null,
            urldownload: dados.urldownload,
            users_id : this.meuperfil.users_id,
            ...this.headers
        };
    }
    getDeleteLivros(id : number) : string {
        return '/api/meuperfil/deleteLivros/Bearer '+this.api_token+'/'+id;
    }
    getDadosLivrosMeuPerfil(dados : object) : object {
         return {
            quantidade : dados.quantidade,
            pagina : dados.pagina ,
            meuperfil_id : this.meuperfil.id ,
            ...this.headers
         }
    }
    getDadosGetMeuPerfilLivrosDoUsuarioQuantidade(users_id) : string {
        return '/api/meuperfil/getMeuPerfilLivrosDoUsuarioQuantidade/Bearer '+this.api_token+'/'+users_id;
    }

    async postLivros(body: object): Promise<LivrosMeuPerfil>
    {
        return await axios.post<LivrosMeuPerfil>('/api/meuperfil/postLivros', body );
    }
    async putLivros(body: object): Promise<LivrosMeuPerfil>
    {
        return await axios.put<LivrosMeuPerfil>('/api/meuperfil/putLivros', body );
    }
    async deleteLivros( url : String): Promise<boolean>
    {
        return await axios.delete<boolean>( url );
    }
    async putMeuPerfil(body : object ) :Promise<putMeuPerfil>
    {
        return await axios.put<putMeuPerfil>('/api/meuperfil/putMeuPerfil', body );
    }
    async postLivrosMeuPerfil(body : object) : Promise<Array<LivrosMeuPerfil>> {

        return await axios.post<LivrosMeuPerfil>('/api/meuperfil/postLivrosMeuPerfil' , body  );
    }
    async getMeuPerfilLivrosDoUsuarioQuantidade(url:string ) : Promise<number>
    {
        return await axios.get<number>(url);
    }
}
