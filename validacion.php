<?php

// -----------------------------------------------------------
// 1. FUNCIÓN DE VALIDACIÓN: Combina un ciclo y condicionales
// -----------------------------------------------------------
function validar_contrasena($contraseña) {
    
    // Condicional 1: Longitud Mínima
    if (strlen($contraseña) < 10) {
        return "La contraseña debe tener al menos 10 caracteres.";
    }
    
    $tiene_mayuscula = false;
    $tiene_minuscula = false;
    $tiene_digito = false;
    $tiene_simbolo = false;
    
    // Ciclo FOR para iterar sobre cada carácter
    for ($i = 0; $i < strlen($contraseña); $i++) {
        $caracter = $contraseña[$i];
        
        // Condicionales 2, 3 y 4: Contenido
        if (ctype_upper($caracter)) {
            $tiene_mayuscula = true;
        } elseif (ctype_lower($caracter)) {
            $tiene_minuscula = true;
        } elseif (ctype_digit($caracter)) {
            $tiene_digito = true;
        } else {
            // Asume que si no es letra o dígito, es un símbolo
            $tiene_simbolo = true; 
        }
    }
    
    // Condicional Final: Verifica si todas las condiciones se cumplieron
    if ($tiene_mayuscula && $tiene_minuscula && $tiene_digito && $tiene_simbolo) {
        return true; // Contraseña válida
    } else {
        return "Debe contener mayúsculas, minúsculas, dígitos y al menos un símbolo.";
    }
}

// Simulación de una contraseña enviada desde un formulario POST
$contrasena_input = isset($_POST['password']) ? $_POST['password'] : 'PruebaSegura123!'; 

// El ciclo WHILE (o do-while) en PHP se usa típicamente para reintentos o 
// procesamiento de colas, pero aquí lo simulamos con el bucle lógico:

$resultado_validacion = validar_contrasena($contrasena_input);

if ($resultado_validacion === true) {
    
    // * PASO DE SEGURIDAD CRÍTICO EN PHP *
    // 1. Hashing: El dato es sanitizado (complejo) y ahora se le aplica un hash (irreversible).
    $hash_seguro = password_hash($contrasena_input, PASSWORD_BCRYPT);
    
    // 2. Almacenamiento: Se enviaría $hash_seguro a la BD
    echo "<h1>ÉXITO: Contraseña validada y hasheada con BCRYPT.</h1>";
    echo "<p>Hash a guardar en BD: <code>" . $hash_seguro . "</code></p>";
    
} else {
    
    // El ciclo se "rompe" lógicamente al no pasar la validación
    // En un entorno web real, esto regresaría al formulario.
    echo "<h1> ERROR DE VALIDACIÓN:</h1>";
    echo "<p>Razón: " . $resultado_validacion . "</p>";
}

?>