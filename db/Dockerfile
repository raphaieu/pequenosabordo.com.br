FROM mysql:8

# Embute o dump no build (Coolify não monta bind volumes de init de forma confiável)
COPY init/ /docker-entrypoint-initdb.d/
