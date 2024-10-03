# Uso

Modificar AppServiceProvider

```
Bouncer::useRoleModel(Role::class);

Relation::morphMap([Role::class]);
```


## Creación de roles y habilidades
Creemos un rol llamado admin y démosle la capacidad ban-user:

```Bouncer::allow('admin')->to('ban-users');```

Eso es todo. Tras bastidores, Bouncer creará un Rolemodelo y una Ability.

Si desea agregar atributos adicionales al rol/habilidad:

```
$admin = Bouncer::role()->firstOrCreate([
    'name' => 'admin',
    'title' => 'Administrator',
]);

$ban = Bouncer::ability()->firstOrCreate([
    'name' => 'ban-users',
    'title' => 'Ban users',
]);

//se agrega a admin el rol ban
Bouncer::allow($admin)->to($ban);
```
## Asignar roles a un usuario

```
Bouncer::assign('admin')->to($user);
```
Alternativamente, puedes llamar al directamente en el usuario:
```
$user = User::find($id);
$user->assign('admin');
```

## Darle a un usuario una habilidad directamente

```Bouncer::allow($user)->to('ban-users');```

Aquí también puedes realizar lo mismo directamente desde el usuario:

```
$user = User::find($id);
$user->allow('ban-users');
```

## Restringir una habilidad a un modelo

A veces, es posible que desees restringir una habilidad a un tipo de modelo específico. Simplemente pasa el nombre del modelo como segundo argumento:

```Bouncer::allow($user)->to('edit', Post::class);```

Si desea restringir la capacidad a una instancia de modelo específico, pase el modelo real en su lugar:

```Bouncer::allow($user)->to('edit', $post);```

## Permitir que un usuario o rol sea "propietario" de un modelo
Utilice el toOwnmétodo para permitir que los usuarios administren sus propios modelos:

```Bouncer::allow($user)->toOwn(Post::class);```

Lo anterior otorgará todas las habilidades en los modelos "propios" de un usuario. Puede restringir las habilidades si realiza una llamada al tométodo:

```Bouncer::allow($user)->toOwn(Post::class)->to('view');```

// Or pass it an array of abilities:
```Bouncer::allow($user)->toOwn(Post::class)->to(['view', 'update']);```
También puedes permitir que los usuarios posean todo tipo de modelos en tu aplicación:

```Bouncer::allow($user)->toOwnEverything();```

// And to restrict ownership to a given ability
```Bouncer::allow($user)->toOwnEverything()->to('view');```

## Retirarle un rol a un usuario

El portero también puede retractar un rol previamente asignado a un usuario:

```Bouncer::retract('admin')->from($user);```

O hazlo directamente en el usuario:

```$user->retract('admin');```

## Eliminar una habilidad
El portero también puede eliminar una habilidad previamente otorgada a un usuario:

```Bouncer::disallow($user)->to('ban-users');```

O directamente en el usuario:

```$user->disallow('ban-users');```

Nota: si el usuario tiene un rol que le permite ban-users, seguirá teniendo esa capacidad. Para deshabilitarla, elimine la capacidad del rol o retírele el rol al usuario.

Si la habilidad ha sido otorgada a través de un rol, dígale al portero que elimine la habilidad del rol:

```Bouncer::disallow('admin')->to('ban-users');```

Para eliminar una habilidad de un tipo de modelo específico, pase su nombre como segundo argumento:

```Bouncer::disallow($user)->to('delete', Post::class);```

Advertencia: si el usuario tiene la capacidad de acceder a deleteuna instancia específica $post, el código anterior no eliminará esa capacidad. Deberá eliminar la capacidad por separado (pasando el valor actual $postcomo segundo argumento), como se muestra a continuación.

Para eliminar una habilidad de una instancia de modelo específica, pase el modelo real en su lugar:

```Bouncer::disallow($user)->to('delete', $post);```

Nota : el disallowmétodo solo elimina las habilidades que se otorgaron previamente a este usuario o rol. Si desea deshabilitar un subconjunto de lo que una habilidad más general ha permitido, utilice el forbidmétodo .

Prohibir una habilidad
Bouncer también te permite asignar forbiduna habilidad determinada para un control más preciso. En ocasiones, es posible que desees otorgarle a un usuario o rol una habilidad que cubra una amplia gama de acciones, pero luego restringir un pequeño subconjunto de esas acciones.

A continuación se muestran algunos ejemplos:

Es posible permitir que un usuario vea todos los documentos en general, pero tener un documento altamente clasificado específico que no se le debería permitir ver:

```Bouncer::allow($user)->to('view', Document::class);```

```Bouncer::forbid($user)->to('view', $classifiedDocument);```

Es posible que desees permitir que tus superadmins hagan todo en tu aplicación, incluso agregar o eliminar usuarios. En ese caso, puedes tener un adminrol que pueda hacer todo, excepto administrar usuarios:

```
Bouncer::allow('superadmin')->everything();

Bouncer::allow('admin')->everything();

Bouncer::forbid('admin')->toManage(User::class);
```


Es posible que desees banear a usuarios ocasionalmente, quitándoles el permiso para todas sus habilidades. Sin embargo, eliminar todos sus roles y habilidades significaría que cuando se elimine la prohibición tendremos que averiguar cuáles eran sus roles y habilidades originales.

Usar una habilidad prohibida significa que pueden conservar todos sus roles y habilidades existentes, pero aún así no estar autorizados para nada. Podemos lograr esto creando un bannedrol especial, al que le prohibiremos todo:

```Bouncer::forbid('banned')->everything();```

Luego, cada vez que queramos banear a un usuario, le asignaremos el bannedrol:

```Bouncer::assign('banned')->to($user);```

Para eliminar la prohibición, simplemente le retiraremos el rol al usuario:

```Bouncer::retract('banned')->from($user);```

Como puedes ver, las habilidades prohibidas de Bouncer te brindan mucho control granular sobre los permisos en tu aplicación.

## Una habilidad imperdible
Para eliminar una habilidad prohibida, utiliza el unforbidmétodo:

```Bouncer::unforbid($user)->to('view', $classifiedDocument);```

Nota : esto eliminará cualquier habilidad prohibida previamente. No permitirá automáticamente la habilidad si no está permitida por una habilidad regular diferente otorgada a este usuario/rol.

## Comprobación de los roles de un usuario
Nota : En términos generales, no debería ser necesario verificar roles directamente. Es mejor permitir que un rol tenga ciertas habilidades y luego verificarlas. Si lo que necesita es muy general, puede crear habilidades muy amplias. Por ejemplo, siempre es mejor crear una habilidad que access-dashboardverificar roles directamente. Para las raras ocasiones en las que desee verificar un rol, esa funcionalidad está disponible aquí.admineditor

El portero puede comprobar si un usuario tiene un rol específico:

```Bouncer::is($user)->a('moderator');```

Si el rol que estás verificando comienza con una vocal, es posible que desees utilizar el anmétodo de alias:

```Bouncer::is($user)->an('admin');```

Para el caso inverso, también puedes comprobar si un usuario no tiene un rol específico:

```Bouncer::is($user)->notA('moderator');```


```Bouncer::is($user)->notAn('admin');```

Puede comprobar si un usuario tiene uno de muchos roles:

```Bouncer::is($user)->a('moderator', 'editor');```

También puedes comprobar si el usuario tiene todos los roles asignados:

```Bouncer::is($user)->all('editor', 'moderator');```

También puedes comprobar si un usuario no tiene ninguno de los roles dados:

```Bouncer::is($user)->notAn('editor', 'moderator');```

Estas comprobaciones también se pueden realizar directamente sobre el usuario:
```
$user->isAn('admin');
$user->isA('subscriber');

$user->isNotAn('admin');
$user->isNotA('subscriber');

$user->isAll('editor', 'moderator');
```
## Consultar usuarios por sus roles

Puede consultar a sus usuarios en función de si tienen un rol determinado:

```$users = User::whereIs('admin')->get();```
También puede pasar múltiples roles para consultar usuarios que tengan alguno de los roles indicados:

```$users = User::whereIs('superadmin', 'admin')->get();```
Para consultar usuarios que tienen todos los roles dados, utilice el whereIsAllmétodo:

```$users = User::whereIsAll('sales', 'marketing')->get();```

## Obtener todos los roles para un usuario
Puede obtener todos los roles de un usuario directamente desde el modelo de usuario:

```$roles = $user->getRoles();```

## Obtener todas las habilidades para un usuario
Puede obtener todas las capacidades de un usuario directamente desde el modelo de usuario:

```$abilities = $user->getAbilities();```

Esto devolverá una colección de las habilidades permitidas del usuario, incluidas todas las habilidades otorgadas al usuario a través de sus roles.

También puedes obtener una lista de habilidades que han sido explícitamente prohibidas:

```$forbiddenAbilities = $user->getForbiddenAbilities();```

## Autorizar usuarios
La autorización de usuarios se gestiona directamente en LaravelGate , o en el modelo de usuario ( $user->can($ability)).

Para mayor comodidad, la Bouncerclase proporciona estos métodos de paso a través:
```
Bouncer::can($ability);
Bouncer::can($ability, $model);

Bouncer::canAny($abilities);
Bouncer::canAny($abilities, $model);

Bouncer::cannot($ability);
Bouncer::cannot($ability, $model);

Bouncer::authorize($ability);
Bouncer::authorize($ability, $model);
```

Estos llaman directamente a sus métodos equivalentes en la Gateclase.

## Directivas de Blade
Bouncer no agrega sus propias directivas de Blade. Dado que Bouncer trabaja directamente con la puerta de Laravel, simplemente use su @candirectiva para verificar las capacidades del usuario actual:
```
@can ('update', $post)
    <a href="{{ route('post.update', $post) }}">Edit Post</a>
@endcan
```
Dado que no se recomienda verificar los roles directamente , Bouncer no incluye una directiva independiente para ello. Si aún así insiste en verificar los roles, puede hacerlo utilizando la @ifdirectiva general:

```
@if ($user->isAn('admin'))
    //
@endif
```

## Actualizando la caché
Todas las consultas ejecutadas por Bouncer se almacenan en caché para la solicitud actual. Si habilita el almacenamiento en caché entre solicitudes , la memoria caché se conservará en distintas solicitudes.

Siempre que lo necesites, puedes actualizar completamente el caché del portero:
```
Bouncer::refresh();
```

Nota: la actualización completa de la memoria caché para todos los usuarios utiliza etiquetas de caché si están disponibles. No todos los controladores de caché admiten esta función. Consulta la documentación de Laravel para ver si tu controlador admite etiquetas de caché. Si tu controlador no admite etiquetas de caché, la llamada refreshpuede ser un poco lenta, según la cantidad de usuarios en tu sistema.

Alternativamente, puede actualizar el caché solo para un usuario específico:
```
Bouncer::refreshFor($user);
```
Nota : cuando se utilizan ámbitos de tenencia múltiple , esto solo actualizará la memoria caché del usuario en el contexto del ámbito actual. Para borrar los datos almacenados en caché del mismo usuario en un contexto de ámbito diferente, se debe llamar desde dentro de ese ámbito.

