import axios from 'axios';
import { Users } from '@/Utils/Entidades/users';
import { ApiRequest } from '@/Utils/apiRequest';
import { MensagensCaixa } from '@/Entidades/mensagensCaixa';
import { PostMensagensLivros } from '@/Entidades/postMensagensLivros';
import { Mensagens } from '@/Entidades/mensagens';
import { GetMensagensLivros } from '@/Entidades/getMensagensLivros';
export class MensagensController {
    public api_token: string;
    private apiRequest: ApiRequest;
    private headers: object;
    constructor(api_token: string ) {
        this.api_token = api_token;
        this.apiRequest = new ApiRequest;
        this.headers = this.apiRequest.getDefaultHeaders(this.api_token);
    }

    async getMensagensCaixa(): Promise<MensagensCaixa>{
        return await axios.post<MensagensCaixa>('/api/mensagens/getMensagensCaixa' ,this.headers );
    };
    async getMensagensLivros(body: object): Promise<GetMensagensLivros>{
        return await axios.post<GetMensagensLivros>('/api/mensagens/getMensagensLivros' ,body)
    };
    async adicionarMensagens(body:object ): Promise<Mensagens>{
        return await axios.post<Mensagens>('/api/mensagens/adicionarMensagens', body);

    };

    async editarMensagens(body: object): Promise<Mensagens>{
        return await axios.post<Mensagens>('/api/mensagens/editarMensagens', body);
    };


    async deletarMensagens(body: object): Promise<Boolean>{
        return await axios.delete<boolean>('/api/mensagens/deleteMensagens' , body );
    };
    getDadosDeletarMensagens(dados: object): object {
        return {
            id: dados.id ,
            meuperfil_id: dados.meuperfil_id ,
            meuperfilamigo_id: dados.meuperfilamigo_id ,
            ...this.headers ,
        };
    }

    getDadosMensagensLivros(livros_id : number ): object{
        return {
            livros_id: livros_id,
            ...this.headers,
        };
    };

    getPostMensagensLivros(dados: object): object {
        return {
            id: dados.id ?? null,
            mensagem: dados.mensagem,
            livros_id: dados.livros_id,
            meuperfil_id: dados.meuperfil_id,
            ...this.headers,
        };
    };



}
