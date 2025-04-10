@component('mail::message')
# 💜 Bem-vindo ao IPoop!

Olá {{ $user->name ?? 'usuário' }}, estamos felizes em ter você por aqui!

Antes de começar a usar todos os recursos da nossa plataforma, precisamos que você **verifique seu endereço de e-mail** clicando no botão abaixo:

@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
Verificar meu e-mail
@endcomponent

Se você não criou esta conta, ignore este e-mail — nenhuma ação será tomada.

---

💡 Lembre-se: apenas usuários com e-mail verificado poderão **avaliar** e **cadastrar novos banheiros públicos** na plataforma.

---
**Equipe IPoop**

@endcomponent
