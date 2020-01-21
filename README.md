# Graphalistic – Neo4J tinker project

Tinkering with Neo4j ... and PHP

# Requirements

* docker with docker compose

# Setup

1. Copy `docker/.env.example` and `php/.env.example` to `.env` and adapt to your needs.
   
   (This step is only required once.)

2. Install Neo4J plugins:
    `make neo4j-plugins`
    
   (This step is only required once.)

3. Launch docker containers:

    `make docker-start`

3. Install composer dependencies:

    `make composer-install`

OR container:

```
    make shell
    composer install
```
    
   (This step is only required when running the first time or after updates.)

# Neo4j

The web interface is by default accessible at:

http://localhost:7474/browser/

## Cypher

Launch a cypher shell via

`make cypher-shell`



# PHP commands

### Raw cypher queries (experimental)

    bin/console graphalistic:query <query>

### Purge database

    bin/console graphalistic:purge -f


# Graphaware Unit Test via REST

    curl -X POST http://neo4j:test@neo4j:7474/graphaware/resttest/assertEmpty