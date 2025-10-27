# 🎯 CONFIGURAÇÃO ASAAS - GUIA COMPLETO

## 📋 **1. Configuração no .env**
```env
ASAAS_API_KEY=sua_api_key_aqui
```

## 🏪 **2. Configuração no Painel Asaas**

### **2.1 Criar Conta Principal**
1. Acesse: https://www.asaas.com
2. Crie sua conta da plataforma
3. Vá em **Configurações** → **API** → **Chaves de API**
4. Copie a **API Key** e cole no `.env`

### **2.2 Ativar Split de Pagamentos**
1. No painel Asaas, vá em **Configurações** → **Split de Pagamentos**
2. **Ative a funcionalidade** (pode levar até 24h para aprovação)
3. Configure as taxas se necessário

### **2.3 Configurar Webhook**
1. Vá em **Configurações** → **Webhooks**
2. Adicione a URL: `https://seudominio.com/webhook/asaas`
3. Selecione os eventos:
   - `PAYMENT_CONFIRMED`
   - `PAYMENT_RECEIVED`
4. Salve a configuração

## 👥 **3. Criar Subcontas para Vendedores**

### **3.1 Pelo Sistema (Automático)**
1. Vendedor acessa: `/seller/asaas-setup`
2. Preenche dados pessoais e endereço
3. Sistema cria subconta automaticamente
4. `asaas_wallet_id` é salvo na tabela `sellers`

### **3.2 Manualmente (Painel Asaas)**
1. No painel, vá em **Subcontas** → **Nova Subconta**
2. Preencha dados do vendedor
3. Após criação, copie o **Wallet ID**
4. Atualize na tabela `sellers`:
```sql
UPDATE sellers SET asaas_wallet_id = 'wallet_id_aqui' WHERE seller_id = X;
```

## 🔧 **4. Configurar Wallet da Plataforma**

No arquivo `AsaasPaymentService.php`, linha 12:
```php
private const PLATFORM_WALLET_ID = 'seu_wallet_id_da_plataforma';
```

**Como obter o Wallet ID da plataforma:**
1. No painel Asaas, vá em **Configurações** → **Dados da Conta**
2. Copie o **Wallet ID** ou **Account ID**
3. Cole na constante acima

## 🧪 **5. Testar a Integração**

Execute o comando de teste:
```bash
php artisan asaas:test
```

Se aparecer "✅ Integração funcionando!", está tudo certo!

## 🚨 **6. Problemas Comuns**

### **Erro: "access_token inválido"**
- Verifique se a API Key está correta no `.env`
- Certifique-se que não há espaços extras

### **Erro: "Split não permitido"**
- Ative Split de Pagamentos no painel
- Aguarde aprovação (até 24h)

### **Erro: "Wallet ID inválido"**
- Verifique se o vendedor tem subconta criada
- Confirme se o `asaas_wallet_id` está correto na tabela

### **Pagamento não aparece no painel**
- Verifique os logs: `storage/logs/laravel.log`
- Procure por "=== ASAAS REQUEST ===" e "=== ASAAS RESPONSE ==="
- Confirme se a URL está correta: `https://api.asaas.com/v3/payments`

## 📊 **7. Monitoramento**

Todos os requests e responses são logados. Para acompanhar:
```bash
tail -f storage/logs/laravel.log | grep ASAAS
```

## 🎉 **8. Resultado Esperado**

Após configuração correta:
- **Cartão de Crédito**: Status `CONFIRMED` (imediato)
- **PIX/Boleto**: Status `PENDING` (aguarda pagamento)
- **Split**: Valores divididos automaticamente entre vendedor e plataforma
- **Webhook**: Confirmação automática quando pago