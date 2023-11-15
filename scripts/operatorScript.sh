#!/bin/bash

# Colores ANSI
GREEN="\033[32m"
RESET="\033[0m"


while true; do
    clear
    echo -e "${GREEN} _____ ______    _______    ________    ___  ___      " 
    echo '|\   _ \  _   \ |\  ___ \  |\   ___  \ |\  \|\  \     '   
    echo '\ \  \\|__| \  \\ \  \_|/__\ \  \\ \  \\ \  \\\  \    '   
    echo ' \ \  \\\__\ \  \\ \   __/| \ \  \\ \  \\ \  \\\  \   '    
    echo '  \ \  \    \ \  \\ \  \_|\ \\ \  \\ \  \\ \  \\\  \  '     
    echo '   \ \__\    \ \__\\ \_______\\ \__\\ \__\\ \_______\ '      
    echo '    \|__|     \|__| \|_______| \|__| \|__| \|_______| '       
    echo ' ________   ________   ___   ________    ________   ___   ________   ________   ___'
    echo '|\   __  \ |\   __  \ |\  \ |\   ___  \ |\   ____\ |\  \ |\   __  \ |\   __  \ |\  \ '
    echo '\ \   ____\\ \   _  _\\ \  \\ \  \\ \  \\ \  \___| \ \  \\ \   ____\\ \   __  \\ \  \ '
    echo ' \ \  \___| \ \  \\  \|\ \  \\ \  \\ \  \\ \  \     \ \  \\ \  \____|\ \  \|\  \\ \  \ '
    echo '  \ \  \     \ \  \\  \ \ \  \\ \  \\ \  \\ \  \____ \ \  \\ \  \     \ \  \ \  \\ \  \____'
    echo '   \ \__\     \ \__\\ _\ \ \__\\ \__\\ \__\\ \_______\\ \__\\ \__\     \ \__\ \__\\ \_______\ '
    echo -e "    \|__|      \|__|\|__| \|__| \|__| \|__| \|_______| \|__| \|__|      \|__|\|__| \|_______|${RESET}"

    echo "1. ABM de Usuarios y Grupos"
    echo "2. Ver logs de usuarios"
    echo "3. Respaldar la configuración"
    echo "4. Respaldar la base de datos"
    echo "5. Salir"
    read -p "Seleccione una opción: " option

    case $option in
        1)
            # Agrega aquí la ruta al script de Alta, Baja y Modificación de Usuarios y Grupos
            /home/nacho/scripts/abmScript.sh
            ;;
        2)
            # Agrega aquí la ruta al script para ver logs de usuarios
            /home/nacho/scripts/logScript.sh
            ;;
        3)
            # Agrega aquí la ruta al script de respaldo de configuración
            /home/nacho/scripts/respaldoConfig.sh
            ;;
        4)
            # Agrega aquí la ruta al script de respaldo de base de datos
            /home/nacho/scripts/respaldoDB.sh
            ;;
        5)
            echo -e "${YELLOW}Saliendo del menú${RESET}"
            exit 0
            ;;
        *)
            echo -e "${RED}Opción inválida. Por favor, seleccione una opción válida.${RESET}"
            ;;
    esac

    read -p "Presione Enter para volver al menú principal..."
done
