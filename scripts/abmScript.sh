#!/bin/bash

# Colores ANSI
GREEN="\033[32m"
YELLOW="\033[33m"
RED="\033[31m"
RESET="\033[0m"

# Función para mostrar un mensaje de éxito en verde
function mostrar_exito {
    echo -e "${GREEN}$1${RESET}"
}

# Función para mostrar un mensaje de advertencia en amarillo
function mostrar_advertencia {
    echo -e "${YELLOW}$1${RESET}"
}

# Función para mostrar un mensaje de error en rojo
function mostrar_error {
    echo -e "${RED}Error: $1${RESET}"
    exit 1
}

# Función para confirmar acciones
function confirmar_accion {
    read -p "¿Está seguro de que desea realizar esta acción? (S/N): " confirm
    if [ "$confirm" != "S" ] && [ "$confirm" != "s" ]; then
        echo "Operación cancelada."
        return 1
    fi
}

while true; do
    clear
    echo -e "${YELLOW}Menú de Gestión de Usuarios y Grupos${RESET}"
    echo "1. Alta de usuario"
    echo "2. Baja de usuario"
    echo "3. Modificación de usuario (cambiar nombre o grupo)"
    echo "4. Alta de grupo"
    echo "5. Baja de grupo"
    echo "6. Mostrar usuarios y grupos personalizados"
    echo "0. Salir"
    read -p "Seleccione una opción: " option

    case $option in
    1)
        read -p "Ingrese el nombre de usuario: " username
        if ! [[ $username =~ ^[a-z_][a-z0-9_]*$ ]]; then
            mostrar_error "Nombre de usuario inválido. Debe comenzar con una letra minúscula y contener solo letras minúsculas, números y guiones bajos."
        fi

        if id "$username" &>/dev/null; then
            mostrar_error "El usuario $username ya existe."
        fi

        echo -e "${YELLOW}Elija el grupo para el usuario $username:${RESET}"
        echo "1. almaceneros"
        echo "2. camioneros"
        echo "3. administradores"
        echo "4. Ninguno (Sin grupo)"
        read -p "Seleccione el número del grupo o '4' para ninguno: " group_option

        case $group_option in
        1)
            groupname="almaceneros"
            ;;
        2)
            groupname="camioneros"
            ;;
        3)
            groupname="administradores"
            ;;
        4)
            groupname=""
            ;;
        *)
            mostrar_error "Opción de grupo inválida. No se creará el usuario."
            ;;
        esac

        if [ -n "$groupname" ]; then
            useradd "$username" -g "$groupname" && mostrar_exito "Usuario $username creado exitosamente en el grupo $groupname"
        else
            useradd "$username" && mostrar_exito "Usuario $username creado exitosamente sin agregar a ningún grupo"
        fi
        ;;
    2)
        read -p "Ingrese el nombre de usuario a eliminar: " username
        if ! id "$username" &>/dev/null; then
            mostrar_error "El usuario $username no existe."
        fi

        confirmar_accion || continue

        userdel -r "$username" && mostrar_exito "Usuario $username eliminado exitosamente"
        ;;
    3)
        clear
        echo -e "${YELLOW}Menú de Modificación de Usuario${RESET}"
        echo "1. Modificar el nombre del usuario"
        echo "2. Modificar el grupo del usuario"
        echo "3. Volver al menú principal"
        read -p "Seleccione una opción: " modify_option

        case $modify_option in
        1)
            read -p "Ingrese el nombre de usuario que desea modificar: " username
            if ! id "$username" &>/dev/null; then
                mostrar_error "El usuario $username no existe."
            fi

            read -p "Ingrese el nuevo nombre de usuario: " new_username

            confirmar_accion || continue

            usermod -l "$new_username" "$username" && mostrar_exito "Nombre del usuario $username modificado a $new_username"
            ;;
        2)
            clear
            echo -e "${YELLOW}Menú de Modificación de Grupo del Usuario${RESET}"
            echo "1. Almaceneros"
            echo "2. Camioneros"
            echo "3. Administradores"
            echo "4. Ninguno (Sin grupo)"
            echo "5. Asignar un grupo distinto (Ingresar nombre)"
            read -p "Seleccione una opción: " group_option

            read -p "Ingrese el nombre de usuario que desea modificar: " username
            if ! id "$username" &>/dev/null; then
                mostrar_error "El usuario $username no existe."
            fi

            case $group_option in
            1)
                groupname="almaceneros"
                ;;
            2)
                groupname="camioneros"
                ;;
            3)
                groupname="administradores"
                ;;
            4)
                groupname=""
                ;;
            5)
                read -p "Ingrese el nombre del grupo: " new_groupname
                if ! getent group "$new_groupname" &>/dev/null; then
                    mostrar_error "El grupo $new_groupname no existe."
                fi
                groupname="$new_groupname"
                ;;
            *)
                mostrar_error "Opción de grupo inválida. No se realizará la modificación."
                ;;
            esac

            confirmar_accion || continue

            if [ -n "$groupname" ]; then
                usermod -g "$groupname" "$username" && mostrar_exito "Grupo del usuario $username modificado a $groupname"
            else
                usermod -g "" "$username" && mostrar_exito "Usuario $username eliminado de cualquier grupo"
            fi
            ;;
        3)
            continue
            ;;
        *)
            mostrar_error "Opción inválida. No se realizarán modificaciones."
            ;;
        esac
        ;;
    4)
        read -p "Ingrese el nombre del grupo: " groupname
        if ! [[ $groupname =~ ^[a-z_][a-z0-9_]*$ ]]; then
            mostrar_error "Nombre de grupo inválido. Debe comenzar con una letra minúscula y contener solo letras minúsculas, números y guiones bajos."
        fi

        groupadd "$groupname" && mostrar_exito "Grupo $groupname creado exitosamente"
        ;;
    5)
        read -p "Ingrese el nombre del grupo a eliminar: " groupname
        if ! getent group "$groupname" &>/dev/null; then
            mostrar_error "El grupo $groupname no existe."
        fi

        confirmar_accion || continue

        groupdel "$groupname" && mostrar_exito "Grupo $groupname eliminado exitosamente"
        ;;
    6)
        clear
            echo -e "${GREEN}Usuarios y Grupos${RESET}"
            echo -e "${YELLOW}Usuarios:${RESET}"
            while IFS=: read -r username _ uid gid _ home shell; do
                if (( uid >= 1000 )) || [ "$username" == "root" ]; then
                    grupo=$(id -gn "$username")
                    echo "$username ($grupo)"
                fi
            done < /etc/passwd

            echo -e "${YELLOW}Grupos:${RESET}"
            while IFS=: read -r groupname _ gid _; do
                if (( gid >= 1000 )) || [ "$groupname" == "root" ]; then
                    echo "$groupname"
                fi
            done < /etc/group
            ;;
    0)
        echo -e "${YELLOW}Saliendo del script${RESET}"
        exit 0
        ;;
    *)
        mostrar_error "Opción inválida. Por favor, seleccione una opción válida."
        ;;
    esac

    read -p "Presione Enter para continuar..."
done
