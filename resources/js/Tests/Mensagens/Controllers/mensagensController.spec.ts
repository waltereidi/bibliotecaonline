import { expect, test } from 'vitest'
import { MensagensController } from "@/Mensagens/Controllers/mensagensController";
import axios  from 'axios';
import { ApiRequest } from '@/Utils/ApiRequest';
import { MensagensCaixa } from '@/Mensagens/Entidades/mensagensCaixa';
import { Mensagens } from '@/Mensagens/Entidades/mensagens';


const a = 1 ;
const b = 2 ;

const mensagensController = new MensagensController;
const apiRequest = new ApiRequest;

test('somar', () => {


  expect(3 ).toBe(3)
})
