# Latte for Symfony

## How to install

- Just install it as standard symfony bundle
- Then just ask for `Latte\Engine` service

## Latte
- See https://latte.nette.org/en/

### Symfony specific macros

#### renderRoute
Makes a request to the given route and prints the result. 
##### Spec
```
{renderRoute <routeName>[, 'routeParams'=>[(<key> => <value>,)...][, 'renderOptions'=>[(<key> => <value>,)...]}
```

##### Example
```latte
{renderRoute myAwesomeRoute,'routeParams'=>['x' => 5, 'y' => 7],'renderOptions'=>['strategy' => 'inline']}
```

#### routePath 

Print the relative URL (without the scheme and host) for the given route.
 
##### Spec
```
{routePath <routeName>[,<key> => <value>]...}
```
```
<a n:href="<routeName>[,<key> => <value>]...">
```
##### Example
```latte
{routePath myAwesomeRoute,'x' => 5,'y' => 7}
```
```latte
<a n:href="myAwesomeRoute,'x' => 5,'y' => 7"></a>
```

#### routeUrl

Print the absolute URL (with scheme and host) for the given route. 

##### Spec
```
{routeUrl <routeName>[,<key> => <value>]...}
```

##### Example
```latte
{routeUrl myAwesomeRoute,'x' => 5,'y' => 7}
```


#### relativePath

Returns the relative path from the passed absolute URL. See [Symfony doc - relative_path](http://symfony.com/doc/current/reference/twig_reference.html#relative-path)

##### Spec
```
{relativePath <absoluteUrl>}
```

##### Example
```latte
{relativePath 'http://example.com/human.txt'}
```



#### absoluteUrl

Returns the absolute URL from the passed relative path. 

##### Spec
```
{absoluteUrl <relativePath>}
```

##### Example
```latte
{absoluteUrl 'human.txt'}
```

#### csrfToken

Renders a CSRF token. Use this function if you want CSRF protection without creating a form.

See [Symfony doc - csrf_token](http://symfony.com/doc/current/reference/twig_reference.html#csrf-token)

##### Spec
```
{csrfToken <intention>}
```


#### logoutUrl - logoutPath

Generates a absolute/relative logout URL for the given firewall. If no key is provided, the URL is generated for the current firewall the user is logged into.

##### Spec
```
{logoutPath [key]}
{logoutUrl [key]}
```


### Symfony filters

#### translate

See [Symfony docs - translation in templates](http://symfony.com/doc/current/translation.html#translations-in-templates)

##### Spec
```
{="<translation.key>"|translate[:[(<argumentName> => <argumentValue>,)...]][:<domain>][:<locale>]}
{_"<translation.key>"}
```
- `domain` - string, optional
- `locale` - string, optional

##### Example
```latte
{="my.awesome.translation.key"|translate:['%name%' => 'Karel','%job%' => 'Metař']}
{="my.awesome.translation.key"}
```

#### translateChoice

See [Symfony docs - translation in templates](http://symfony.com/doc/current/translation.html#translations-in-templates)

##### Spec
```
{="<translation.key>"|translateChoice:<count>[:[(<argumentName> => <argumentValue>,)...]][:<domain>][:<locale>]}
```
- `count` - int, required
- `domain` - string, optional
- `locale` - string, optional

##### Example
```latte
{="my.awesome.translation.key"|translateChoice:5:['%name%' => 'Karel','%job%' => 'Metař']}
```

## How to expand

### Macros

#### Simple macro
- Class [`\Mangoweb\LatteBundle\Macro\SimpleMacro`](/src/Macro/SimpleMacro.php) is wrapper for macroSet->addMacro() (see https://latte.nette.org/en/#toc-user-defined-macros)
- Extend class and mark service with service tag `- { name: latte.simple_macro }`
- Or Implement [`\Mangoweb\LatteBundle\Macro\ISimpleMacroProvider`](/src/Macro/ISimpleMacroProvider.php) 
and mark it with service tag `- { name: latte.simple_macro_provider }`  

#### Advanced macro
- Implement directly `\Latte\IMacro`
- Register service and mark it with service tag `- { name: latte.advanced_macro, macro_name: fooBar }`

### Filters

#### Filter provider
- Implement [`\Mangoweb\LatteBundle\Filter\IFilterProvider`](/src/Filter/IFilterProvider.php)
- Mark service with service tags: `{name: 'latte.filter_provider'}`

### Providers 
- Create service and tag it with `- {name: 'latte.provider', provider_name: fooBar }`
- This will then be avabile at runtime in latte via `$this->global->fooBar`
