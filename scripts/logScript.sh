#!/bin/bash

# Colores ANSI
GREEN="\033[32m"
YELLOW="\033[33m"
RED="\033[31m"
RESET="\033[0m"

# Función para mostrar registros de inicio de sesión exitosos en verde
function mostrar_inicios_exitosos {
    echo -e "${GREEN}Registros de Inicio de Sesión Exitosos:${RESET}"
    local registros=$(journalctl | grep "sshd" | grep "Accepted")
    if [ -z "$registros" ]; then
        echo "No hay registros de inicio de sesión exitosos."
    else
        echo "$registros"
    fi
}

# Función para mostrar registros de inicio de sesión fallidos en amarillo
function mostrar_inicios_fallidos {
    echo -e "${YELLOW}Registros de Inicio de Sesión Fallidos:${RESET}"
    local registros=$(journalctl | grep "sshd" | grep "Failed")
    if [ -z "$registros" ]; then
        echo "No hay registros de inicio de sesión fallidos."
    else
        echo "$registros"
    fi
}

# Función para mostrar registros de intentos de inicio de sesión por usuario en rojo
function mostrar_registros_por_usuario {
    read -p "Ingrese el nombre de usuario: " usuario
    echo -e "${RED}Registros de Inicio de Sesión para el Usuario $usuario:${RESET}"
    local registros=$(journalctl | grep "sshd" | grep "Accepted\|Failed" | grep "$usuario")
    if [ -z "$registros" ]; then
        echo "No hay registros de inicio de sesión para el usuario $usuario."
    else
        echo "$registros"
    fi
}

# Función principal del script
function main {
    clear
    echo "Acceso a registros de inicio de sesión del sistema"
    echo "1. Mostrar Inicios de Sesión Exitosos"
    echo "2. Mostrar Inicios de Sesión Fallidos"
    echo "3. Mostrar Registros por Usuario"
    echo "4. Salir"
    
    read -p "Seleccione una opción: " opcion

    case $opcion in
        1)
            mostrar_inicios_exitosos
            ;;
        2)
            mostrar_inicios_fallidos
            ;;
        3)
            mostrar_registros_por_usuario
            ;;
        4)
            echo "Saliendo del script"
            exit 0
            ;;
        *)
            echo -e "${GREEN}Opción inválida. Por favor, seleccione una opción válida.${RESET}"
            ;;
    esac

    read -p "Presione Enter para continuar..."
    main
}

# Llama a la función principal del script
main
