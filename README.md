# boraCome
Não um dos meus trabalhos mais gloriosos, apenas uma POC de Push Notification usando SW

Foram criados os seguintes crons:

40 11 * * 1,2,3,4,5 wget -O boraCome/back/enviaHoraComida.php
30 12 * * * wget -O /dev/null boraCome/back/zera.php
