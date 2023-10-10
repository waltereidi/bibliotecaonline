import { ref , computed } from "vue";
import { defineStore } from 'pinia';
import { MeuPerfilController } from "@/MeuPerfil/meuperfilController";

export const meuperfilStore = defineStore('meuperfil',{
    state: () => {
        return {
                user :{
                api_token : 'Bearer ' ,
                users_id : 0 ,
                meuperfil_id: 0 ,
                meuPerfilController : null ,
            },
            datasource:{

            },
            quantidadeLivros : 0 ,
            messages:{
                erro : false ,
                alerta : false ,
                sucesso : false ,
                carregando : false ,
            },
            response:'',
        }
    },
    getters: {
        getDataSource:(state) => {
            return state.datasource ;
        },
        getQuantidade:(state)=>{
            return state.quantidadeLivros;
        },
        getMessages:(state) => {
            return state.messages;
        },
        getUsersId:(state)=>{
            return state.user;
        },
        getResponse:(state)=>{
            return state.response;
        }

    },
    actions: {
        message(tipo:string){
            switch(tipo){
                case 'erro':this.messages.erro=true;setTimeout(()=>{this.messages.erro=false;},2000);break;
                case 'alerta':this.messages.alerta=true;setTimeout(()=>{this.messages.alerta=false;},2000);break;
                case 'sucesso':this.messages.sucesso=true;setTimeout(()=>{this.messages.sucesso=false;},2000);break;
                default :this.messages.erro=true;setTimeout(()=>{this.messages.erro=false;},2000);break;
            }
        },
        setUser(meuperfil:object , api_token: string , quantidadeLivros : number, datasource?:object )
        {
            this.user.api_token = api_token ;
            this.user.users_id = meuperfil.users_id ;
            this.user.meuperfil_id = meuperfil.meuperfil_id;
            this.quantidadeLivros = quantidadeLivros ;
            this.datasource = datasource ;

            this.user.meuPerfilController = ref(new MeuPerfilController(api_token, meuperfil));
        },
        async atualizarDataSource( quantidade:number, pagina:number)
        {
            this.messages.carregando = true ;

            const dados = this.user.meuPerfilController.getDadosLivrosMeuPerfil({
                quantidade : quantidade ,
                pagina : pagina ,
                meuperfil_id : this.user.meuperfil_id,
            });
            const retorno = await this.user.meuPerfilController.postLivrosMeuPerfil(dados);
            if(retorno.status===200)
            {
                this.datasource = retorno.data ;
            }
            this.messages.carregando=false;

        },
        async postLivros(datasource:object) : number
        {

            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDadosLivros(datasource) ;
            const retorno =await this.user.meuPerfilController.postLivros(dados);
            await this.atualizarDataSource(6,0);
            this.message.carregando = false ;

            if(retorno.status === 201 )
            {
                this.message('sucesso');
                return 201 ;
            }else{
                console.log(retorno);
                return 500;
            }
        },
        async putLivros(datasource:object) : number
        {
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDadosLivros(datasource) ;
            const retorno =await this.user.meuPerfilController.putLivros(dados);
            await this.atualizarDataSource(6,0);
            this.message.carregando = false ;

            if(retorno.status === 200 )
            {
                this.message('sucesso');
                return 200 ;
            }else{
                if(retorno.status===204)
                {
                    console.log(retorno);
                    this.message('alerta');
                    return 204;
                }
                console.log(retorno);
                return 500;
            }
        },
        async deleteLivros(id:number): number
        {
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDeleteLivros(id);

            const retorno =await this.user.meuPerfilController.deleteLivros(dados);

            if( retorno.status === 200)
            {
                this.atualizarDataSource(6,0);
                this.message('sucesso');
                return 200 ;
            }else{
                this.message('alerta');
                return 204;
            }

        },
        async putMeuPerfil(datasource : object ) : number
        {
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getPutMeuPerfil(datasource);
            const retorno = await this.user.meuPerfilController.putMeuPerfil(dados);

            if(retorno.status === 200 )
            {
                this.message('sucesso');
            }else{
                console.log(retorno);
                if(retorno.status === 204)
                {
                    this.message('alerta');
                }else{
                    this.message('erro');
                }
            }


        },
    }

} );
