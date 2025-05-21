# Installazione del Progetto

1. **Clona il repository**

    ```bash
    git clone https://github.com/galactic1106/ygo.git
    cd ygo
    ```

2. **Installa le dipendenze**
    ```bash
    composer install
    ```
    ```bash
    npm install && npm run build
    ```
3. **Configura le variabili d'ambiente**  
   Copia il file di esempio e modifica i parametri necessari:

    ```bash
    cp .env.example .env
    ```

    configura le variabili

4. **Generazione della chiave dell'app**

    php artisan key:generate

5. **Migrazione del database**

	php artisan migrate

6. **Generazione del resto del db**	

	esegui lo script sql per creare il resto delle tabelle

4. **Avvia il progetto**
   se funziona
    ```bash
    composer run dev
    ```
    altrimenti apri due terminali ed esegui
    ```bash
    npm run dev
    ```
	+
    ```bash
    php artisan serve
    ```
5. **Accedi all'applicazione**  
   Apri il browser e vai su [http://localhost:8000]

> Consulta la documentazione per ulteriori dettagli sulla configurazione avanzata.
