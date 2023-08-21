import axios from 'axios';
import { Users } from '@/Utils/Entidades/users';
import { ApiRequest } from '@/Utils/ApiRequest';
import { MensagensCaixa } from '@/Mensagens/Entidades/mensagensCaixa';

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

    }


}
