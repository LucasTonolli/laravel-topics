# DocVault — Gerenciador de Documentos

Projeto de estudo para fixação prática de conceitos fundamentais do Laravel puro, sem pacotes extras.

Usuários fazem upload de documentos, organizam em pastas e compartilham com outros usuários. Cada funcionalidade exercita um conceito diferente do framework.

## Entidades

```
User ──┐
       ├── hasMany ── Folder
       ├── hasMany ── Document (owner)
       └── belongsToMany ── Document (shared via pivot document_user)

Folder ── hasMany ── Document
Document ── belongsTo ── User, Folder
```

## Conceitos Estudados

### 1. Config vs .env

- Arquivo `config/docvault.php` centraliza as configurações da aplicação (tamanho máximo de upload, tipos permitidos, disco, limite de pastas)
- Valores sensíveis e variáveis por ambiente ficam no `.env`
- `env()` nunca é chamado fora de `config/` — tudo via `config('docvault.*')`
- Funciona corretamente com `php artisan config:cache`

### 2. Request Lifecycle

- **LogRequestTime** — middleware global que mede a duração de cada request (antes e depois do `$next`)
- **EnsureFolderLimit** — middleware de rota aplicado apenas na criação de pastas, lendo o limite do config
- Entendimento do fluxo: Kernel → Middleware Global → Router → Middleware de Rota → Controller → Response

### 3. Service Container & Service Providers

- **DocumentServiceInterface** — contrato com métodos `upload`, `delete`, `download`
- **DocumentService** — implementação concreta injetada via interface
- **DocVaultServiceProvider** — registra o binding como singleton, injetando configurações do `config/docvault.php` no construtor
- Resolução automática via type-hint nos controllers

### 4. Form Requests

- **StoreFolderRequest** — nome obrigatório, unique por usuário
- **UpdateFolderRequest** — unique ignorando o próprio registro via `$this->route('folder')`
- **StoreDocumentRequest** — validação de arquivo (mimes e max) lendo do config, authorize verifica dono da pasta
- **ShareDocumentRequest** — authorize via policy, impede compartilhar consigo mesmo com `not_in`

### 5. Policies & Gates

- **FolderPolicy** — apenas o dono pode ver, editar e deletar suas pastas
- **DocumentPolicy** — dono tem acesso total; viewers podem ver e baixar; editors podem ver, baixar e editar; só o dono deleta e compartilha
- Métodos privados `isOwner`, `isEditor`, `isViewer` eliminam duplicação
- `authorizeResource` no construtor dos controllers protege todos os métodos RESTful
- Rotas custom (`share`, `download`) protegidas via middleware `can`

### 6. Events & Listeners

- **DocumentUploaded** → dispara após upload; listener `LogDocumentActivity` registra no log
- **DocumentShared** → dispara após compartilhamento; listener `NotifySharedUser` registra no log
- Listeners síncronos (decisão pragmática — escrita de log não justifica fila)
- Auto-discovery do Laravel 11+ por convenção de type-hint no `handle`

### 7. Queues & Jobs

- Driver `database` com tabela `jobs` e `failed_jobs`
- **ProcessDocumentMetadata** — job assíncrono que lê o arquivo do storage e extrai mime type, tamanho e nome; o request retorna sem esperar
- Distinção conceitual: Event/Listener responde a "algo aconteceu"; Job é uma ordem direta de "faça isso"

### 8. File Storage & Filesystem Abstraction

- Disco custom `documents` (driver local) configurado em `config/filesystems.php`
- Upload via `Storage::disk()->putFileAs()` organizando por slug da pasta
- Download controlado via rota protegida por policy (arquivos nunca expostos publicamente)
- Deleção sincroniza banco e storage
- `DB::transaction` no upload para consistência entre banco e disco
- Troca de driver (local → S3) sem alterar código de negócio

## Setup

```bash
# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Banco de dados
php artisan migrate

# Iniciar o servidor
php artisan serve

# Processar filas (em terminal separado)
php artisan queue:work
```

## Variáveis de Ambiente (DocVault)

```env
DOCVAULT_MAX_UPLOAD_SIZE=10
DOCVAULT_ALLOWED_FILE_TYPES=pdf,docx,txt
DOCVAULT_UPLOAD_DISK=documents
DOCVAULT_MAX_DIR_COUNT=10
QUEUE_CONNECTION=database
```
