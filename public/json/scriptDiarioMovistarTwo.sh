
#!/bin/bash


# Rutas de entorno
pathOrigen="/var/log/portalwap/"
pathScripts="/root/CDRs/reportes/"

#######################################################################

YEAR=$(date +%Y)
Mes=$(date +%m)
Dia=$(date +%d)
Fecha=$(date +%Y,%m,%d --date=" -1 day -1 month")
variable='d'

DIA=$(date +%Y-%m-%d --date="-1 day")
AYER=$(($(date +%Y%m%d) -1))

Day=$(date +%A)
    if [ $Day = "lunes" ]; then
        SEMANA=$(($(date +%V)-1))
    else
        SEMANA=$(date +%V)
    fi

cat $pathOrigen/${AYER}*.moso > $pathOrigen/diario${SEMANA}${AYER}.estadistica
cp  $pathOrigen/diario${SEMANA}${AYER}.estadistica  $pathScripts
rm  $pathOrigen/diario${SEMANA}${AYER}.estadistica


####################GUARDAR DIARIAMENTE LOS USUARIOS Y VISITAS EN UN REPORTE SEMANAL#################################
Visitas=$(cat $pathScripts/diario${SEMANA}${AYER}.estadistica |wc -l)
##HOME NUEVO $(cat $pathScripts/diario${SEMANA}${AYER}.estadistica | awk -F"," ' $8=="home"' | wc -l)
Home=$(cat $pathScripts/diario${SEMANA}${AYER}.estadistica | grep index | wc -l)
Usuarios=$(cat $pathScripts/diario${SEMANA}${AYER}.estadistica | awk -F"," '{ print $6 }'| sort | uniq -c |wc -l)

####################GRAFICO DE BARRAS CON USUARIO-VISITAS OPCION 1#################################
                if [ -f $pathScripts/visitaUsuario${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/visitaUsuario${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/visitaUsuario${YEAR}${SEMANA}.json
                        echo "   ,[\""${DIA}"\","${Home}","$Usuarios"]" >>$pathScripts/visitaUsuario${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/visitaUsuario${YEAR}${SEMANA}.json
                else
                        echo "[" >>$pathScripts/visitaUsuario${YEAR}${SEMANA}.json
                        echo "    [\"Dia\", \"VISITAS\", \"USUARIOS\"]," >>$pathScripts/visitaUsuario${YEAR}${SEMANA}.json
                        echo "    [\""${DIA}"\","${Home}","$Usuarios"]" >>$pathScripts/visitaUsuario${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/visitaUsuario${YEAR}${SEMANA}.json
                fi

####################GRAFICO DE BARRAS CON USUARIO-VISITAS OPCION 2#################################
if [ -f $pathScripts/visitaHomeDos${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/visitaHomeDos${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/visitaHomeDos${YEAR}${SEMANA}.json
                        echo "   ,{\"y\":\""${DIA}"\",\"a\":"${Home}",\"b\":"${Usuarios}"}" >>$pathScripts/visitaHomeDos${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/visitaHomeDos${YEAR}${SEMANA}.json
                else
                        echo "[" >>$pathScripts/visitaHomeDos${YEAR}${SEMANA}.json
                          echo "    {\"y\":\""${DIA}"\",\"a\":"${Home}",\"b\":"${Usuarios}"}" >>$pathScripts/visitaHomeDos${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/visitaHomeDos${YEAR}${SEMANA}.json
                fi

####################GRAFICO DE LINEAL VISITAS HOME#################################
                if [ -f $pathScripts/visitaHome${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/visitaHome${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/visitaHome${YEAR}${SEMANA}.json
                        echo "   ,{\"y\":\""${DIA}"\",\"item1\":"${Home}"}" >>$pathScripts/visitaHome${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/visitaHome${YEAR}${SEMANA}.json
                else
                        echo "[" >>$pathScripts/visitaHome${YEAR}${SEMANA}.json
                        echo "    {\"y\":\""${DIA}"\",\"item1\":"${Home}"}" >>$pathScripts/visitaHome${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/visitaHome${YEAR}${SEMANA}.json
                fi

####################GRAFICO DE LINEAL NAVEGACION TOTAL #################################
                if [ -f $pathScripts/traficoTotal${YEAR}${SEMANA}.json ]; then
                     contador=$(cat $pathScripts/traficoTotal${YEAR}${SEMANA}.json |wc -l)
                        sed -i "$contador$variable" $pathScripts/traficoTotal${YEAR}${SEMANA}.json
                        echo "   ,{\"y\":\""${DIA}"\",\"item1\":"${Visitas}"}" >>$pathScripts/traficoTotal${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/traficoTotal${YEAR}${SEMANA}.json
                else
                        echo "[" >>$pathScripts/traficoTotal${YEAR}${SEMANA}.json
                        echo "    {\"y\":\""${DIA}"\",\"item1\":"${Visitas}"}" >>$pathScripts/traficoTotal${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/traficoTotal${YEAR}${SEMANA}.json
                fi


####################TABLA DE BANNERS#################################
####################REPORTE DIARIO IMPRESIONES BANNERS HOME#################################

                if [ -f $pathScripts/banners${YEAR}${SEMANA}.json ]; then
                     
                sed -i "2 s/]}/,{\"v\": "${Visitas}"}]}/g"  $pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                sed -i "3 s/]}/,{\"v\": "${Home}"}]}/g"  $pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                sed -i "4 s/]}/,{\"v\": "${Usuarios}"}]}/g"  $pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                else
                        echo "[" >>$pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                        echo "   {\"c\": [{\"v\": \"Visita Total\"},{\"v\": "${Visitas}"}]}" >>$pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                        echo "   ,{\"c\": [{\"v\": \"Visita al Home\"},{\"v\": "${Home}"}]}" >>$pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                        echo "   ,{\"c\": [{\"v\": \"Usuarios Unicos\"},{\"v\": "${Usuarios}"}]}" >>$pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                        echo "]" >>$pathScripts/bannersConsolidado${YEAR}${SEMANA}.json
                fi


#############################TABLA DE BANNERS#################################
cat $pathOrigen/${AYER}*.banners > $pathOrigen/banners${SEMANA}${AYER}.estadistica
cp  $pathOrigen/banners${SEMANA}${AYER}.estadistica  $pathScripts
rm  $pathOrigen/banners${SEMANA}${AYER}.estadistica
##############################REPORTE DIARIO IMPRESIONES BANNER POR INTEGRADOR############################################
                 for m in `seq 1 10`; do
                   valorFinal=$(($m*3))
                   mivarV=$(($valorFinal+1))
                   Constante=$(($m+5))
                   mivar=$(($valorFinal-2))
                   while [ $mivar -ne $mivarV ]
                        do
                           linea=$(head -$mivar $pathScripts/banner.txt | tail -1)
                           valor=$(cat $pathScripts/banners${SEMANA}${AYER}.estadistica | awk -F"," -v var="$linea" -v numeral="$Constante" ' $numeral==var { print "," var }'| sort | uniq -c | sort -r)
                           if [ -z $valor ]; then
                               echo "0 ,$linea">>$pathScripts/banner.temporalImpresiones
                             else
                                echo $valor>>$pathScripts/banner.temporalImpresiones
                                fi
                            mivar=$(( $mivar + 1 ))
                        done
                     done
      if [ -f $pathScripts/banners${YEAR}${SEMANA}.json ]; then
             for y in `seq 1 30`; do
                linea=$(head -$y $pathScripts/banner.txt | tail -1)
                    contador=$(($y+1))
               valor=$(cat $pathScripts/banner.temporalImpresiones | awk -F"," -v var="$linea" ' $2==var { print $1 }')
               result=$valor
                sed -i "$contador s/]},/,{\"v\": $result}]},/g"  $pathScripts/banners${YEAR}${SEMANA}.json
             done 
             contador30=$(($(cat $pathScripts/banners${YEAR}${SEMANA}.json |wc -l)-1))
             linea30=$(head -30 $pathScripts/banner.txt | tail -1)
            valor30=$(cat $pathScripts/banner.temporalImpresiones | awk -F"," -v var="$linea30" ' $2==var { print $1 }')
             sed -i "$contador30 s/]}/,{\"v\": $valor30}]}/g"  $pathScripts/banners${YEAR}${SEMANA}.json
        else
               echo "[" >>$pathScripts/banners${YEAR}${SEMANA}.json
                                  oldIFS=$IFS   
                                  IFS=$''
                                    valor=$(cat $pathScripts/banner.temporalImpresiones | awk -F"," '{ print "    {\"c\": [{\"v\": \""$2"\"},{\"v\": "$1"}]}," }')
                                   echo $valor>>$pathScripts/banners${YEAR}${SEMANA}.json
                                  IFS=$old_IFS
               echo "]" >>$pathScripts/banners${YEAR}${SEMANA}.json
               contador=$(($(cat $pathScripts/banners${YEAR}${SEMANA}.json |wc -l)-1))
              sed -i "$contador s/]},/]}/g"  $pathScripts/banners${YEAR}${SEMANA}.json
           fi
         rm $pathScripts/banner.temporalImpresiones
 


    

####################GRAFICO ANUAL DE VISITAS HOME #################################
                     contadorHome=$(cat $pathScripts/visitasDiariasAnual.json |wc -l)
                        sed -i "$contadorHome$variable" $pathScripts/visitasDiariasAnual.json
                         echo "        ,{\"c\": [{\"v\":\"Date("${Fecha}")\"},{\"v\": "${Home}"} ]}" >>$pathScripts/visitasDiariasAnual.json
                        echo "]}" >>$pathScripts/visitasDiariasAnual.json
              

####################GRAFICO ANUAL DE VISITAS TOTALES #################################
                     contadorAnual=$(cat $pathScripts/visitasTotalDiariasAnual.json |wc -l)
                        sed -i "$contadorAnual$variable" $pathScripts/visitasTotalDiariasAnual.json
                         echo "        ,{\"c\": [{\"v\":\"Date("${Fecha}")\"},{\"v\": "${Visitas}"} ]}" >>$pathScripts/visitasTotalDiariasAnual.json
                        echo "]}" >>$pathScripts/visitasTotalDiariasAnual.json
              

####################GRAFICO ANUAL DE USUARIOS UNICOS #################################
                     contadorUsuario=$(cat $pathScripts/visitasDiariasAnualUsuariosUnicos.json |wc -l)
                        sed -i "$contadorUsuario$variable" $pathScripts/visitasDiariasAnualUsuariosUnicos.json
                         echo "        ,{\"c\": [{\"v\":\"Date("${Fecha}")\"},{\"v\": "${Usuarios}"} ]}" >>$pathScripts/visitasDiariasAnualUsuariosUnicos.json
                        echo "]}" >>$pathScripts/visitasDiariasAnualUsuariosUnicos.json
              

rm  $pathScripts/diario${SEMANA}${AYER}.estadistica
rm  $pathScripts/banners${SEMANA}${AYER}.estadistica
