import { MeuPerfilDados } from "@/Entidades/meuperfilDados";
import axios from "axios";
import { ApiRequest } from "@/Utils/ApiRequest";
import { LivrosMeuPerfil } from "@/Entidades/livrosMeuperfil";
export class MeuPerfilController{
    public api_token: string;
    private apiRequest: ApiRequest;
    private headers: object;
    constructor(api_token: string ) {
        this.api_token = api_token;
        this.apiRequest = new ApiRequest;
        this.headers = this.apiRequest.getDefaultHeaders(this.api_token);
    }

    somar( a:number , b:number ) : number {
        return a+b ;
    }
    async getDadosMeuPerfil() :Promise<MeuPerfilDados> {
        return await axios.post<MeuPerfilDados>('/api/meuperfil/getDadosMeuPerfil',
            this.headers
        );
    }

    async getLivrosMeuPerfil(paginacao:number = 0): Promise<LivrosMeuPerfil> {
        let body: object = this.headers;
        body["paginacao"] = paginacao;
        return await axios.post<LivrosMeuPerfil>('/api/meuperfil/getPaginacaoLivrosDoUsuario',
        body  );
    }
    getEditarMeuPerfil( dados ):object {
        return {
            id : dados.id??null ,
            users_id : dados.users_id??null ,
            introducao : dados.introducao??null ,
            profile_picture : dados.profile_picture??null ,
            datanascimento : dados.datanascimento??null ,
            ...this.headers
        }

    }
    async editarMeuPerfil(body: object ): Promise<MeuPerfilDados> {

        return await axios.post<MeuPerfilDados>('/api/meuperfil/editarMeuPerfil',
        this.headers ,body );
    }
    getPostLivros(dados): object{

        return {
            id: dados.id??null ,
            titulo: dados.titulo??null,
            descricao: dados.descricao??null,
            visibilidade: dados.visibilidade??null,
            isbn: dados.isbn??null,
            editoras_nome: dados.editoras_nome??null,
            autores_nome: dados.autores_nome??null,
            capalivro: dados.capalivro??null,
            genero: dados.genero??null,
            idioma: dados.idioma??null,
            ...this.headers
        };
    }

    async adicionarLivros(body: object): Promise<LivrosMeuPerfil>{
        return await axios.post<LivrosMeuPerfil>('/api/meuperfil/adicionarLivros',
            body
        );
    }
    async editarLivros(body: object): Promise<LivrosMeuPerfil>{
        return await axios.put<LivrosMeuPerfil>('/api/meuperfil/editarLivros',
            body );
    }
    async deletarLivros(id): Promise<boolean>{
        return await axios.delete<boolean>(`/api/meuperfil / removerLivros / ${id}`);
    }

}
