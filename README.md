# BE Tic-Tac-Toe Assignment

L’obiettivo di questo assignment è avere una piccola base codice scritta di recente da valutare e da usare come base per un confronto in call.  
Consiste nel creare un’**API che permetta di svolgere una partita di tic-tac-toe (tris)**.

Premia sicuramente un approccio **KISS** (Keep It Simple, Stupid) senza overengineering, potendo comunque esporre altre soluzioni più complesse durante il confronto.  

Il backend sarà utilizzato da un frontend sviluppato da un altro team, ma sono stati forniti i requisiti di prodotto che devono essere esposti come API.

📖 Riferimento: [Tic-Tac-Toe - Wikipedia](https://en.wikipedia.org/wiki/Tic-tac-toe)

---

## Requisiti API

1. **Nuova partita**
    - Endpoint per avviare una nuova partita.
    - La risposta deve restituire un **Game ID** da utilizzare nelle chiamate successive.

2. **Giocare una mossa**
    - Endpoint per giocare una mossa.
    - Input richiesti:
        - `game_id`: l’ID partita (fornito al punto 1).
        - `player`: il numero del giocatore (`1` o `2`).
        - `position`: la posizione della mossa.
    - La risposta deve includere:
        - Una **rappresentazione della board** aggiornata.
        - Un **flag** che indichi se la partita è terminata e, in caso positivo, chi è il vincitore.

3. **Validazione mosse**
    - L’endpoint che gestisce le mosse deve:
        - Verificare che la mossa sia valida.
        - Controllare che sia il turno corretto (un giocatore non può fare due mosse di fila).
        - Evitare che un giocatore piazzi un segno sopra quello dell’altro.

---

## Test

Non serve implementare un’interfaccia grafica (UI).  
L’API può essere testata tramite **cURL** o strumenti simili.

È richiesto un **test case di esempio** (es. lista di comandi `curl`) che mostri una partita completa eseguita con la tua implementazione.

---

## Specifiche Tecniche

- Puoi utilizzare **qualsiasi linguaggio** per il backend (preferenza per **PHP** se è uno dei tuoi principali).
- Puoi scegliere liberamente qualsiasi datastore per salvare lo stato della partita.
- La soluzione deve essere **semplice e leggibile**.
- Tempo stimato: **2-4 ore**.
---
