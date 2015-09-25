#!/bin/bash      
YEAR=$(date +%Y)
DIADOS=$(date +%d/%m --date="-1 day")
AYER=$(($(date +%Y%m%d) -1))

DIA=$(date +%A)
    if [ $DIA = "lunes" ]; then
        SEMANA=$(($(date +%V)-1))
    else
        SEMANA=$(date +%V)
    fi

variable='d'
# rutas de entorno
pathOrigen="/var/log/portalwap/"
documentJson="/var/www/html/portalwap2Produccion/json/"
pathScripts="/root/CDRs/reportes/"

cat $pathOrigen/${AYER}*.moso > $pathOrigen/diario${SEMANA}${AYER}.consolidado
cp  $pathOrigen/diario${SEMANA}${AYER}.consolidado  $pathScripts
rm  $pathOrigen/diario${SEMANA}${AYER}.consolidado

         ####################REPORTE DIARIO CLICKS SERVICIOS#################################
          cat $pathScripts/diario${SEMANA}${AYER}.consolidado | awk -F"," ' $8=="servicio" { print ","$8 ","$9 }'| sort | uniq -c | sort -r >> $pathScripts/servicios.temporal
          if [ -f $pathScripts/servicios${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/servicios${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/servicios${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/servicios${YEAR}${SEMANA}.json
                         for y in `seq 1 8`; do
                        linea=$(head -$y $pathScripts/nombreServicio.data | tail -1)
                        valor=$(cat $pathScripts/servicios.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                       if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/servicios${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                else
                        for i in `seq 0 7`; do
                        valor=$(cat $documentJson/SERVICIO.json | jq ".["$i"].alt")
                          echo $valor>>$pathScripts/nombreServicio.data
                         done
                        sed -i "s/\"//g"  $pathScripts/nombreServicio.data
                        echo "[" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                        echo -n  " [" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                         echo -n  "\"Dia\"" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                       for i in `seq 1 8`; do
                            linea=$(head -$i $pathScripts/nombreServicio.data | tail -1)
                            echo -n ",\""$linea"\"">>$pathScripts/servicios${YEAR}${SEMANA}.json
                           done
                         echo   "]" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                         echo  -n ",[\"$DIADOS\""  >> $pathScripts/servicios${YEAR}${SEMANA}.json
                       for y in `seq 1 8`; do
                        linea=$(head -$y $pathScripts/nombreServicio.data | tail -1)
                        valor=$(cat $pathScripts/servicios.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                        if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/servicios${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/servicios${YEAR}${SEMANA}.json
                fi
                 rm $pathScripts/servicios.temporal
       ####################REPORTE DIARIO CLICKS JUEGO#################################
            cat $pathScripts/diario${SEMANA}${AYER}.consolidado | awk -F"," ' $8=="juego" { print ","$8 ","$9 }'| sort | uniq -c | sort -r >> $pathScripts/juego.temporal
            if [ -f $pathScripts/juego${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/juego${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/juego${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/juego${YEAR}${SEMANA}.json
                        for y in `seq 1 5`; do
                        linea=$(head -$y $pathScripts/nombreJuego.data | tail -1)
                        valor=$(cat $pathScripts/juego.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                        if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/juego${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/juego${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/juego${YEAR}${SEMANA}.json
                else
                        for i in `seq 0 4`; do
                        valor=$(cat $documentJson/JUEGO.json | jq ".["$i"].nombre")
                          echo $valor>>$pathScripts/nombreJuego.data
                         done
                        sed -i "s/\"//g"  $pathScripts/nombreJuego.data
                        echo "[" >>$pathScripts/juego${YEAR}${SEMANA}.json
                        echo -n  " [" >>$pathScripts/juego${YEAR}${SEMANA}.json
                         echo -n  "\"Dia\"" >>$pathScripts/juego${YEAR}${SEMANA}.json
                       for i in `seq 1 5`; do
                            linea=$(head -$i $pathScripts/nombreJuego.data | tail -1)
                            echo -n ",\""$linea"\"">>$pathScripts/juego${YEAR}${SEMANA}.json
                           done
                        echo  "]" >>$pathScripts/juego${YEAR}${SEMANA}.json
                         echo  -n ",[\"$DIADOS\""  >> $pathScripts/juego${YEAR}${SEMANA}.json
                       for y in `seq 1 5`; do
                        linea=$(head -$y $pathScripts/nombreJuego.data | tail -1)
                        valor=$(cat $pathScripts/juego.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                        if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/juego${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/juego${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/juego${YEAR}${SEMANA}.json
                fi
                 rm $pathScripts/juego.temporal
            ####################REPORTE DIARIO CLICKS MUSICA#################################
               cat $pathScripts/diario${SEMANA}${AYER}.consolidado | awk -F"," ' $8=="musica" { print ","$8 ","$9 }'| sort | uniq -c | sort -r >> $pathScripts/musica.temporal
                if [ -f $pathScripts/musica${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/musica${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/musica${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/musica${YEAR}${SEMANA}.json
                         for y in `seq 1 5`; do
                        linea=$(head -$y $pathScripts/nombreMusica.data | tail -1)
                        valor=$(cat $pathScripts/musica.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                       if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/musica${YEAR}${SEMANA}.json
                       done
                 echo  "]" >>$pathScripts/musica${YEAR}${SEMANA}.json
                 echo  "]" >>$pathScripts/musica${YEAR}${SEMANA}.json
                else
                        for i in `seq 0 4`; do
                        valor=$(cat $documentJson/MUSICA.json | jq ".["$i"].titulo")
                          echo $valor>>$pathScripts/nombreMusica.data
                         done
                        sed -i "s/\"//g"  $pathScripts/nombreMusica.data
                        echo "[" >>$pathScripts/musica${YEAR}${SEMANA}.json
                        echo -n  " [" >>$pathScripts/musica${YEAR}${SEMANA}.json
                         echo -n  "\"Dia\"" >>$pathScripts/musica${YEAR}${SEMANA}.json
                       for i in `seq 1 5`; do
                            linea=$(head -$i $pathScripts/nombreMusica.data | tail -1)
                            echo -n ",\""$linea"\"">>$pathScripts/musica${YEAR}${SEMANA}.json
                           done
                        echo   "]" >>$pathScripts/musica${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/musica${YEAR}${SEMANA}.json
                       for y in `seq 1 5`; do
                        linea=$(head -$y $pathScripts/nombreMusica.data | tail -1)
                        valor=$(cat $pathScripts/musica.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                       if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/musica${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/musica${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/musica${YEAR}${SEMANA}.json
                fi
                 rm $pathScripts/musica.temporal
               ####################REPORTE DIARIO CLICKS TEXTLINK#################################
                 cat $pathScripts/diario${SEMANA}${AYER}.consolidado | awk -F"," ' $8=="textLink" { print ","$8 ","$9 }'| sort | uniq -c | sort -r >> $pathScripts/textLink.temporal
                 if [ -f $pathScripts/textLink${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/textLink${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/textLink${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/textLink${YEAR}${SEMANA}.json
                         for y in `seq 1 4`; do
                        linea=$(head -$y $pathScripts/nombreTextLink.data | tail -1)
                        valor=$(cat $pathScripts/textLink.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                       if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/textLink${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                else
                        for i in `seq 0 3`; do
                        valor=$(cat $documentJson/TEXT.json | jq ".["$i"].alt")
                          echo $valor>>$pathScripts/nombreTextLink.data
                         done
                        sed -i "s/\"//g"  $pathScripts/nombreTextLink.data
                        echo "[" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                        echo -n  " [" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                         echo -n  "\"Dia\"" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                       for i in `seq 1 4`; do
                            linea=$(head -$i $pathScripts/nombreTextLink.data | tail -1)
                            echo -n ",\""$linea"\"">>$pathScripts/textLink${YEAR}${SEMANA}.json
                           done
                        echo   "]" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/textLink${YEAR}${SEMANA}.json
                       for y in `seq 1 4`; do
                        linea=$(head -$y $pathScripts/nombreTextLink.data | tail -1)
                        valor=$(cat $pathScripts/textLink.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                        if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/textLink${YEAR}${SEMANA}.json
                       done
                 echo  "]" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/textLink${YEAR}${SEMANA}.json
                fi
                  rm $pathScripts/textLink.temporal
             ####################REPORTE DIARIO CLICKS TOPLINK#################################    
              cat $pathScripts/diario${SEMANA}${AYER}.consolidado | awk -F"," ' $8=="topLink" { print ","$8 ","$9 }'| sort | uniq -c | sort -r >> $pathScripts/topLink.temporal
                 if [ -f $pathScripts/topLink${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/topLink${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/topLink${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/topLink${YEAR}${SEMANA}.json
                         for y in `seq 1 4`; do
                        linea=$(head -$y $pathScripts/nombreTopLink.data | tail -1)
                        valor=$(cat $pathScripts/topLink.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                       if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/topLink${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                else
                        for i in `seq 0 3`; do
                        valor=$(cat $documentJson/LINK.json | jq ".["$i"].descripcion")
                          echo $valor>>$pathScripts/nombreTopLink.data
                         done
                        sed -i "s/\"//g"  $pathScripts/nombreTopLink.data
                        echo "[" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                        echo   " [" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                         echo -n  "\"Dia\"" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                       for i in `seq 1 4`; do
                            linea=$(head -$i $pathScripts/nombreTopLink.data | tail -1)
                            echo -n ",\""$linea"\"">>$pathScripts/topLink${YEAR}${SEMANA}.json
                           done
                        echo   "]" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                         echo -n ",[\"$DIADOS\""  >> $pathScripts/topLink${YEAR}${SEMANA}.json
                       for y in `seq 1 4`; do
                        linea=$(head -$y $pathScripts/nombreTopLink.data | tail -1)
                        valor=$(cat $pathScripts/topLink.temporal | awk -F"," -v var="$linea" ' $3==var { print $1 }')
                      if [ -z $valor ]; then
                          valor=0
                         fi
                        echo -n ","$valor"">>$pathScripts/topLink${YEAR}${SEMANA}.json
                       done
                 echo   "]" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                 echo   "]" >>$pathScripts/topLink${YEAR}${SEMANA}.json
                fi
                 rm $pathScripts/topLink.temporal
                        #############################TABLA DE BANNERS#################################
           ##############################REPORTE DIARIO CLICKS BANNER POR INTEGRADOR############################################

     for y in `seq 1 30`; do
                  linea=$(head -$y $pathScripts/banner.txt | tail -1)
                  valor=$(cat $pathScripts/diario${SEMANA}${AYER}.consolidado | awk -F"," -v var="$linea" ' $8==var { print ","$8 ","$9 }'| sort | uniq -c | sort -r)
                     if [ -z $valor ]; then
                       echo "0 ,$linea,">>$pathScripts/banner.temporal
                     else
                        echo $valor>>$pathScripts/banner.temporal
                        fi
                     done
      if [ -f $pathScripts/bannersClic${YEAR}${SEMANA}.json ]; then
             for y in `seq 1 30`; do
                linea=$(head -$y $pathScripts/banner.txt | tail -1)
                    contador=$(($y+1))
               result=$(cat $pathScripts/banner.temporal | awk -F"," -v var="$linea" ' $2==var { print $1 }')
                sed -i "$contador s/]},/,{\"v\":$result}]},/g"  $pathScripts/bannersClic${YEAR}${SEMANA}.json
             done 
             contador30=$(($(cat $pathScripts/bannersClic${YEAR}${SEMANA}.json |wc -l)-1))
             linea30=$(head -30 $pathScripts/banner.txt | tail -1)
            valor30=$(cat $pathScripts/banner.temporal | awk -F"," -v var="$linea30" ' $2==var { print $1 }')
             sed -i "$contador30 s/]}/,{\"v\": $valor30}]}/g"  $pathScripts/bannersClic${YEAR}${SEMANA}.json
               ####################CABECERA#################################   
             contadorName=$(cat $pathScripts/bannersName${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contadorName$variable" $pathScripts/bannersName${YEAR}${SEMANA}.json
                        echo "   ,{\"id\": \""${DIADOS}"\", \"label\": \""${DIADOS}"\", \"type\": \"number\"}" >>$pathScripts/bannersName${YEAR}${SEMANA}.json 
                        echo "]" >>$pathScripts/bannersName${YEAR}${SEMANA}.json  
        else
               echo "[" >>$pathScripts/bannersClic${YEAR}${SEMANA}.json
                                  oldIFS=$IFS   
                                  IFS=$''
                                    valor=$(cat $pathScripts/banner.temporal | awk -F"," '{ print "    {\"c\": [{\"v\": \""$2"("$3")\"},{\"v\":"$1"}]}," }')
                                   echo $valor>>$pathScripts/bannersClic${YEAR}${SEMANA}.json
                                  IFS=$old_IFS
               echo "]" >>$pathScripts/bannersClic${YEAR}${SEMANA}.json
               contador=$(($(cat $pathScripts/bannersClic${YEAR}${SEMANA}.json |wc -l)-1))
              sed -i "$contador s/]},/]}/g"  $pathScripts/bannersClic${YEAR}${SEMANA}.json
              ####################CABECERA#################################
               echo "[" >>$pathScripts/bannersName${YEAR}${SEMANA}.json
               echo "   {\"id\": \"banner\", \"label\": \"banner\", \"type\": \"string\"}" >>$pathScripts/bannersName${YEAR}${SEMANA}.json 
               echo "   ,{\"id\": \""${DIADOS}"\", \"label\": \""${DIADOS}"\", \"type\": \"number\"}" >>$pathScripts/bannersName${YEAR}${SEMANA}.json 
               echo "]" >>$pathScripts/bannersName${YEAR}${SEMANA}.json
        fi
           rm $pathScripts/banner.temporal
        rm  $pathScripts/diario${SEMANA}${AYER}.consolidado

  DIA=$(date +%A)
    if [ $DIA = "lunes" ]; then
     rm    $pathScripts/nombreServicio.data
     rm    $pathScripts/nombreJuego.data
     rm    $pathScripts/nombreMusica.data
     rm    $pathScripts/nombreTextLink.data
     rm    $pathScripts/nombreTopLink.data
    else

    fi
