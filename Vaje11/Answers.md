# Answers

## List three use cases for real-time web applications (chat and and real-time email client do not count:)

1. Skupno urejanje dokumentov: Spletne aplikacije v realnem času se lahko uporabljajo za skupno urejanje dokumentov, kar omogoča več uporabnikom, da v realnem času hkrati delajo na istem dokumentu. Spremembe, ki jih opravi en uporabnik, se takoj odražajo pri vseh drugih uporabnikih, kar omogoča nemoteno sodelovanje in odpravlja potrebo po ročni sinhronizaciji.

2. Vizualizacija podatkov v živo: Spletne aplikacije v realnem času se lahko uporabljajo za vizualizacijo podatkov v živo, pri čemer se podatki iz različnih virov stalno posodabljajo in prikazujejo. To je lahko uporabno v aplikacijah, kot so finančne nadzorne plošče, sistemi za spremljanje interneta stvari ali platforme za analitiko v realnem času, kjer lahko uporabniki opazujejo in analizirajo podatke, ko se ustvarjajo ali posodabljajo.

3. Spletne dražbe in licitiranje: Spletne aplikacije v realnem času so primerne za spletne dražbe in platforme za licitiranje. Uporabniki lahko oddajajo ponudbe, prejemajo takojšnje posodobitve o trenutni najvišji ponudbi in sodelujejo v dinamičnem postopku. Posodobitve v realnem času zagotavljajo, da imajo udeleženci najnovejše informacije in se lahko hitro odzovejo na spreminjajoče se pogoje dražbe.

## Find a use case where a AJAX polling is a better solution than web-sockets:

Eden od primerov uporabe, kjer je lahko poizvedovanje AJAX boljša rešitev, kot WebSockets, je uporaba v starejših sistemih ali okoljih, ki ne podpirajo vtičnikov WebSockets.


## Would it be possible to implement server-sent events in your single-threaded web server from the 2nd homework assignment? Why?

Da, bilo bi mogoče in sicer zato, ker je ena nit najmanjša enota toka ukazov, lahko izvršuje eno-smerno povezavo, v tem primeru neskončni odgovor strežnika klientu. Vendar to pride z slabost, da nato strežnik ne moremo uporabiti za druge akcije, saj je njegova ena nit vedno zasedena z to SSE povezavo.
