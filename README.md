# Manager

Um sistema de gerenciamento desenvolvido com Laravel 12, Livewire 3 e Tailwind CSS.

## 🚀 Tecnologias Utilizadas

- PHP 8.2+
- Laravel 12
- Livewire 3
- Tailwind CSS
- Laravel Jetstream
- Laravel Sanctum
- Vite

## 📋 Pré-requisitos

- PHP 8.2 ou superior
- Composer
- Node.js e NPM
- SQLite (ou outro banco de dados suportado pelo Laravel)

## 🔧 Instalação

1. Clone o repositório:
```bash
git clone [URL_DO_REPOSITÓRIO]
cd manager
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Instale as dependências do Node.js:
```bash
npm install
```

4. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure o banco de dados no arquivo `.env`

6. Execute as migrações:
```bash
php artisan migrate
```

7. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

8. Em outro terminal, inicie o Vite:
```bash
npm run dev
```

## 🛠️ Scripts Disponíveis

- `composer dev` - Inicia o ambiente de desenvolvimento completo (servidor, filas, logs e Vite)
- `composer test` - Executa os testes automatizados
- `php artisan serve` - Inicia o servidor de desenvolvimento
- `npm run dev` - Compila os assets em modo de desenvolvimento
- `npm run build` - Compila os assets para produção

## 📁 Estrutura do Projeto

```
manager/
├── app/            # Código fonte principal
├── bootstrap/      # Arquivos de inicialização
├── config/         # Arquivos de configuração
├── database/       # Migrações e seeders
├── public/         # Ponto de entrada da aplicação
├── resources/      # Views, assets não compilados
├── routes/         # Definições de rotas
├── storage/        # Arquivos gerados pela aplicação
└── tests/          # Testes automatizados
```

## 🔐 Segurança

O projeto utiliza Laravel Sanctum para autenticação e proteção de APIs. Certifique-se de configurar corretamente as variáveis de ambiente relacionadas à segurança no arquivo `.env`.

## 🧪 Testes

Para executar os testes:

```bash
composer test
```

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 🤝 Contribuição

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Faça o Commit das suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Faça o Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📧 Suporte

Para suporte, abra uma issue no repositório.
