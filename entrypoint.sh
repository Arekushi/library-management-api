#!/bin/bash

# Executar migrações
echo "Executando migrações..."
composer run migrate

# Verificar se o script de migração foi executado com sucesso
if [ $? -ne 0 ]; then
  echo "Erro ao executar migrações"
  exit 1
fi

# Iniciar o Apache
echo "Iniciando o Apache..."
apache2-foreground
