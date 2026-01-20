<?php

// This file is auto-generated and is for apps only. Bundles SHOULD NOT rely on its content.

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

/**
 * This class provides array-shapes for configuring the services and bundles of an application.
 *
 * Services declared with the config() method below are autowired and autoconfigured by default.
 *
 * This is for apps only. Bundles SHOULD NOT use it.
 *
 * Example:
 *
 *     ```php
 *     // config/services.php
 *     namespace Symfony\Component\DependencyInjection\Loader\Configurator;
 *
 *     return App::config([
 *         'services' => [
 *             'App\\' => [
 *                 'resource' => '../src/',
 *             ],
 *         ],
 *     ]);
 *     ```
 *
 * @psalm-type ImportsConfig = list<string|array{
 *     resource: string,
 *     type?: string|null,
 *     ignore_errors?: bool,
 * }>
 * @psalm-type ParametersConfig = array<string, scalar|\UnitEnum|array<scalar|\UnitEnum|array<mixed>|null>|null>
 * @psalm-type ArgumentsType = list<mixed>|array<string, mixed>
 * @psalm-type CallType = array<string, ArgumentsType>|array{0:string, 1?:ArgumentsType, 2?:bool}|array{method:string, arguments?:ArgumentsType, returns_clone?:bool}
 * @psalm-type TagsType = list<string|array<string, array<string, mixed>>> // arrays inside the list must have only one element, with the tag name as the key
 * @psalm-type CallbackType = string|array{0:string|ReferenceConfigurator,1:string}|\Closure|ReferenceConfigurator|ExpressionConfigurator
 * @psalm-type DeprecationType = array{package: string, version: string, message?: string}
 * @psalm-type DefaultsType = array{
 *     public?: bool,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 * }
 * @psalm-type InstanceofType = array{
 *     shared?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     properties?: array<string, mixed>,
 *     configurator?: CallbackType,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 * }
 * @psalm-type DefinitionType = array{
 *     class?: string,
 *     file?: string,
 *     parent?: string,
 *     shared?: bool,
 *     synthetic?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     abstract?: bool,
 *     deprecated?: DeprecationType,
 *     factory?: CallbackType,
 *     configurator?: CallbackType,
 *     arguments?: ArgumentsType,
 *     properties?: array<string, mixed>,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     decorates?: string,
 *     decoration_inner_name?: string,
 *     decoration_priority?: int,
 *     decoration_on_invalid?: 'exception'|'ignore'|null,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 *     from_callable?: CallbackType,
 * }
 * @psalm-type AliasType = string|array{
 *     alias: string,
 *     public?: bool,
 *     deprecated?: DeprecationType,
 * }
 * @psalm-type PrototypeType = array{
 *     resource: string,
 *     namespace?: string,
 *     exclude?: string|list<string>,
 *     parent?: string,
 *     shared?: bool,
 *     lazy?: bool|string,
 *     public?: bool,
 *     abstract?: bool,
 *     deprecated?: DeprecationType,
 *     factory?: CallbackType,
 *     arguments?: ArgumentsType,
 *     properties?: array<string, mixed>,
 *     configurator?: CallbackType,
 *     calls?: list<CallType>,
 *     tags?: TagsType,
 *     resource_tags?: TagsType,
 *     autowire?: bool,
 *     autoconfigure?: bool,
 *     bind?: array<string, mixed>,
 *     constructor?: string,
 * }
 * @psalm-type StackType = array{
 *     stack: list<DefinitionType|AliasType|PrototypeType|array<class-string, ArgumentsType|null>>,
 *     public?: bool,
 *     deprecated?: DeprecationType,
 * }
 * @psalm-type ServicesConfig = array{
 *     _defaults?: DefaultsType,
 *     _instanceof?: InstanceofType,
 *     ...<string, DefinitionType|AliasType|PrototypeType|StackType|ArgumentsType|null>
 * }
 * @psalm-type ExtensionType = array<string, mixed>
 * @psalm-type CoreShopMenuConfig = array{
 *     autoconfigure_with_attributes?: scalar|null, // Default: false
 * }
 * @psalm-type CoreShopPimcoreConfig = array{
 *     autoconfigure_with_attributes?: scalar|null, // Default: false
 *     pimcore_admin?: array{
 *         js?: array<string, scalar|null>,
 *         css?: array<string, scalar|null>,
 *         editmode_js?: array<string, scalar|null>,
 *         editmode_css?: array<string, scalar|null>,
 *     },
 * }
 * @psalm-type FrameworkConfig = array{
 *     secret?: scalar|null,
 *     http_method_override?: bool, // Set true to enable support for the '_method' request parameter to determine the intended HTTP method on POST requests. // Default: false
 *     allowed_http_method_override?: list<string>|null,
 *     trust_x_sendfile_type_header?: scalar|null, // Set true to enable support for xsendfile in binary file responses. // Default: "%env(bool:default::SYMFONY_TRUST_X_SENDFILE_TYPE_HEADER)%"
 *     ide?: scalar|null, // Default: "%env(default::SYMFONY_IDE)%"
 *     test?: bool,
 *     default_locale?: scalar|null, // Default: "en"
 *     set_locale_from_accept_language?: bool, // Whether to use the Accept-Language HTTP header to set the Request locale (only when the "_locale" request attribute is not passed). // Default: false
 *     set_content_language_from_locale?: bool, // Whether to set the Content-Language HTTP header on the Response using the Request locale. // Default: false
 *     enabled_locales?: list<scalar|null>,
 *     trusted_hosts?: list<scalar|null>,
 *     trusted_proxies?: mixed, // Default: ["%env(default::SYMFONY_TRUSTED_PROXIES)%"]
 *     trusted_headers?: list<scalar|null>,
 *     error_controller?: scalar|null, // Default: "error_controller"
 *     handle_all_throwables?: bool, // HttpKernel will handle all kinds of \Throwable. // Default: true
 *     csrf_protection?: bool|array{
 *         enabled?: scalar|null, // Default: null
 *         stateless_token_ids?: list<scalar|null>,
 *         check_header?: scalar|null, // Whether to check the CSRF token in a header in addition to a cookie when using stateless protection. // Default: false
 *         cookie_name?: scalar|null, // The name of the cookie to use when using stateless protection. // Default: "csrf-token"
 *     },
 *     form?: bool|array{ // Form configuration
 *         enabled?: bool, // Default: true
 *         csrf_protection?: array{
 *             enabled?: scalar|null, // Default: null
 *             token_id?: scalar|null, // Default: null
 *             field_name?: scalar|null, // Default: "_token"
 *             field_attr?: array<string, scalar|null>,
 *         },
 *     },
 *     http_cache?: bool|array{ // HTTP cache configuration
 *         enabled?: bool, // Default: false
 *         debug?: bool, // Default: "%kernel.debug%"
 *         trace_level?: "none"|"short"|"full",
 *         trace_header?: scalar|null,
 *         default_ttl?: int,
 *         private_headers?: list<scalar|null>,
 *         skip_response_headers?: list<scalar|null>,
 *         allow_reload?: bool,
 *         allow_revalidate?: bool,
 *         stale_while_revalidate?: int,
 *         stale_if_error?: int,
 *         terminate_on_cache_hit?: bool,
 *     },
 *     esi?: bool|array{ // ESI configuration
 *         enabled?: bool, // Default: false
 *     },
 *     ssi?: bool|array{ // SSI configuration
 *         enabled?: bool, // Default: false
 *     },
 *     fragments?: bool|array{ // Fragments configuration
 *         enabled?: bool, // Default: false
 *         hinclude_default_template?: scalar|null, // Default: null
 *         path?: scalar|null, // Default: "/_fragment"
 *     },
 *     profiler?: bool|array{ // Profiler configuration
 *         enabled?: bool, // Default: false
 *         collect?: bool, // Default: true
 *         collect_parameter?: scalar|null, // The name of the parameter to use to enable or disable collection on a per request basis. // Default: null
 *         only_exceptions?: bool, // Default: false
 *         only_main_requests?: bool, // Default: false
 *         dsn?: scalar|null, // Default: "file:%kernel.cache_dir%/profiler"
 *         collect_serializer_data?: bool, // Enables the serializer data collector and profiler panel. // Default: false
 *     },
 *     workflows?: bool|array{
 *         enabled?: bool, // Default: false
 *         workflows?: array<string, array{ // Default: []
 *             audit_trail?: bool|array{
 *                 enabled?: bool, // Default: false
 *             },
 *             type?: "workflow"|"state_machine", // Default: "state_machine"
 *             marking_store?: array{
 *                 type?: "method",
 *                 property?: scalar|null,
 *                 service?: scalar|null,
 *             },
 *             supports?: list<scalar|null>,
 *             definition_validators?: list<scalar|null>,
 *             support_strategy?: scalar|null,
 *             initial_marking?: list<scalar|null>,
 *             events_to_dispatch?: list<string>|null,
 *             places?: list<array{ // Default: []
 *                 name: scalar|null,
 *                 metadata?: list<mixed>,
 *             }>,
 *             transitions: list<array{ // Default: []
 *                 name: string,
 *                 guard?: string, // An expression to block the transition.
 *                 from?: list<array{ // Default: []
 *                     place: string,
 *                     weight?: int, // Default: 1
 *                 }>,
 *                 to?: list<array{ // Default: []
 *                     place: string,
 *                     weight?: int, // Default: 1
 *                 }>,
 *                 weight?: int, // Default: 1
 *                 metadata?: list<mixed>,
 *             }>,
 *             metadata?: list<mixed>,
 *         }>,
 *     },
 *     router?: bool|array{ // Router configuration
 *         enabled?: bool, // Default: false
 *         resource: scalar|null,
 *         type?: scalar|null,
 *         cache_dir?: scalar|null, // Deprecated: Setting the "framework.router.cache_dir.cache_dir" configuration option is deprecated. It will be removed in version 8.0. // Default: "%kernel.build_dir%"
 *         default_uri?: scalar|null, // The default URI used to generate URLs in a non-HTTP context. // Default: null
 *         http_port?: scalar|null, // Default: 80
 *         https_port?: scalar|null, // Default: 443
 *         strict_requirements?: scalar|null, // set to true to throw an exception when a parameter does not match the requirements set to false to disable exceptions when a parameter does not match the requirements (and return null instead) set to null to disable parameter checks against requirements 'true' is the preferred configuration in development mode, while 'false' or 'null' might be preferred in production // Default: true
 *         utf8?: bool, // Default: true
 *     },
 *     session?: bool|array{ // Session configuration
 *         enabled?: bool, // Default: false
 *         storage_factory_id?: scalar|null, // Default: "session.storage.factory.native"
 *         handler_id?: scalar|null, // Defaults to using the native session handler, or to the native *file* session handler if "save_path" is not null.
 *         name?: scalar|null,
 *         cookie_lifetime?: scalar|null,
 *         cookie_path?: scalar|null,
 *         cookie_domain?: scalar|null,
 *         cookie_secure?: true|false|"auto", // Default: "auto"
 *         cookie_httponly?: bool, // Default: true
 *         cookie_samesite?: null|"lax"|"strict"|"none", // Default: "lax"
 *         use_cookies?: bool,
 *         gc_divisor?: scalar|null,
 *         gc_probability?: scalar|null,
 *         gc_maxlifetime?: scalar|null,
 *         save_path?: scalar|null, // Defaults to "%kernel.cache_dir%/sessions" if the "handler_id" option is not null.
 *         metadata_update_threshold?: int, // Seconds to wait between 2 session metadata updates. // Default: 0
 *         sid_length?: int, // Deprecated: Setting the "framework.session.sid_length.sid_length" configuration option is deprecated. It will be removed in version 8.0. No alternative is provided as PHP 8.4 has deprecated the related option.
 *         sid_bits_per_character?: int, // Deprecated: Setting the "framework.session.sid_bits_per_character.sid_bits_per_character" configuration option is deprecated. It will be removed in version 8.0. No alternative is provided as PHP 8.4 has deprecated the related option.
 *     },
 *     request?: bool|array{ // Request configuration
 *         enabled?: bool, // Default: false
 *         formats?: array<string, string|list<scalar|null>>,
 *     },
 *     assets?: bool|array{ // Assets configuration
 *         enabled?: bool, // Default: true
 *         strict_mode?: bool, // Throw an exception if an entry is missing from the manifest.json. // Default: false
 *         version_strategy?: scalar|null, // Default: null
 *         version?: scalar|null, // Default: null
 *         version_format?: scalar|null, // Default: "%%s?%%s"
 *         json_manifest_path?: scalar|null, // Default: null
 *         base_path?: scalar|null, // Default: ""
 *         base_urls?: list<scalar|null>,
 *         packages?: array<string, array{ // Default: []
 *             strict_mode?: bool, // Throw an exception if an entry is missing from the manifest.json. // Default: false
 *             version_strategy?: scalar|null, // Default: null
 *             version?: scalar|null,
 *             version_format?: scalar|null, // Default: null
 *             json_manifest_path?: scalar|null, // Default: null
 *             base_path?: scalar|null, // Default: ""
 *             base_urls?: list<scalar|null>,
 *         }>,
 *     },
 *     asset_mapper?: bool|array{ // Asset Mapper configuration
 *         enabled?: bool, // Default: false
 *         paths?: array<string, scalar|null>,
 *         excluded_patterns?: list<scalar|null>,
 *         exclude_dotfiles?: bool, // If true, any files starting with "." will be excluded from the asset mapper. // Default: true
 *         server?: bool, // If true, a "dev server" will return the assets from the public directory (true in "debug" mode only by default). // Default: true
 *         public_prefix?: scalar|null, // The public path where the assets will be written to (and served from when "server" is true). // Default: "/assets/"
 *         missing_import_mode?: "strict"|"warn"|"ignore", // Behavior if an asset cannot be found when imported from JavaScript or CSS files - e.g. "import './non-existent.js'". "strict" means an exception is thrown, "warn" means a warning is logged, "ignore" means the import is left as-is. // Default: "warn"
 *         extensions?: array<string, scalar|null>,
 *         importmap_path?: scalar|null, // The path of the importmap.php file. // Default: "%kernel.project_dir%/importmap.php"
 *         importmap_polyfill?: scalar|null, // The importmap name that will be used to load the polyfill. Set to false to disable. // Default: "es-module-shims"
 *         importmap_script_attributes?: array<string, scalar|null>,
 *         vendor_dir?: scalar|null, // The directory to store JavaScript vendors. // Default: "%kernel.project_dir%/assets/vendor"
 *         precompress?: bool|array{ // Precompress assets with Brotli, Zstandard and gzip.
 *             enabled?: bool, // Default: false
 *             formats?: list<scalar|null>,
 *             extensions?: list<scalar|null>,
 *         },
 *     },
 *     translator?: bool|array{ // Translator configuration
 *         enabled?: bool, // Default: true
 *         fallbacks?: list<scalar|null>,
 *         logging?: bool, // Default: false
 *         formatter?: scalar|null, // Default: "translator.formatter.default"
 *         cache_dir?: scalar|null, // Default: "%kernel.cache_dir%/translations"
 *         default_path?: scalar|null, // The default path used to load translations. // Default: "%kernel.project_dir%/translations"
 *         paths?: list<scalar|null>,
 *         pseudo_localization?: bool|array{
 *             enabled?: bool, // Default: false
 *             accents?: bool, // Default: true
 *             expansion_factor?: float, // Default: 1.0
 *             brackets?: bool, // Default: true
 *             parse_html?: bool, // Default: false
 *             localizable_html_attributes?: list<scalar|null>,
 *         },
 *         providers?: array<string, array{ // Default: []
 *             dsn?: scalar|null,
 *             domains?: list<scalar|null>,
 *             locales?: list<scalar|null>,
 *         }>,
 *         globals?: array<string, string|array{ // Default: []
 *             value?: mixed,
 *             message?: string,
 *             parameters?: array<string, scalar|null>,
 *             domain?: string,
 *         }>,
 *     },
 *     validation?: bool|array{ // Validation configuration
 *         enabled?: bool, // Default: true
 *         cache?: scalar|null, // Deprecated: Setting the "framework.validation.cache.cache" configuration option is deprecated. It will be removed in version 8.0.
 *         enable_attributes?: bool, // Default: true
 *         static_method?: list<scalar|null>,
 *         translation_domain?: scalar|null, // Default: "validators"
 *         email_validation_mode?: "html5"|"html5-allow-no-tld"|"strict"|"loose", // Default: "html5"
 *         mapping?: array{
 *             paths?: list<scalar|null>,
 *         },
 *         not_compromised_password?: bool|array{
 *             enabled?: bool, // When disabled, compromised passwords will be accepted as valid. // Default: true
 *             endpoint?: scalar|null, // API endpoint for the NotCompromisedPassword Validator. // Default: null
 *         },
 *         disable_translation?: bool, // Default: false
 *         auto_mapping?: array<string, array{ // Default: []
 *             services?: list<scalar|null>,
 *         }>,
 *     },
 *     annotations?: bool|array{
 *         enabled?: bool, // Default: false
 *     },
 *     serializer?: bool|array{ // Serializer configuration
 *         enabled?: bool, // Default: true
 *         enable_attributes?: bool, // Default: true
 *         name_converter?: scalar|null,
 *         circular_reference_handler?: scalar|null,
 *         max_depth_handler?: scalar|null,
 *         mapping?: array{
 *             paths?: list<scalar|null>,
 *         },
 *         default_context?: list<mixed>,
 *         named_serializers?: array<string, array{ // Default: []
 *             name_converter?: scalar|null,
 *             default_context?: list<mixed>,
 *             include_built_in_normalizers?: bool, // Whether to include the built-in normalizers // Default: true
 *             include_built_in_encoders?: bool, // Whether to include the built-in encoders // Default: true
 *         }>,
 *     },
 *     property_access?: bool|array{ // Property access configuration
 *         enabled?: bool, // Default: true
 *         magic_call?: bool, // Default: false
 *         magic_get?: bool, // Default: true
 *         magic_set?: bool, // Default: true
 *         throw_exception_on_invalid_index?: bool, // Default: false
 *         throw_exception_on_invalid_property_path?: bool, // Default: true
 *     },
 *     type_info?: bool|array{ // Type info configuration
 *         enabled?: bool, // Default: true
 *         aliases?: array<string, scalar|null>,
 *     },
 *     property_info?: bool|array{ // Property info configuration
 *         enabled?: bool, // Default: true
 *         with_constructor_extractor?: bool, // Registers the constructor extractor.
 *     },
 *     cache?: array{ // Cache configuration
 *         prefix_seed?: scalar|null, // Used to namespace cache keys when using several apps with the same shared backend. // Default: "_%kernel.project_dir%.%kernel.container_class%"
 *         app?: scalar|null, // App related cache pools configuration. // Default: "cache.adapter.filesystem"
 *         system?: scalar|null, // System related cache pools configuration. // Default: "cache.adapter.system"
 *         directory?: scalar|null, // Default: "%kernel.share_dir%/pools/app"
 *         default_psr6_provider?: scalar|null,
 *         default_redis_provider?: scalar|null, // Default: "redis://localhost"
 *         default_valkey_provider?: scalar|null, // Default: "valkey://localhost"
 *         default_memcached_provider?: scalar|null, // Default: "memcached://localhost"
 *         default_doctrine_dbal_provider?: scalar|null, // Default: "database_connection"
 *         default_pdo_provider?: scalar|null, // Default: null
 *         pools?: array<string, array{ // Default: []
 *             adapters?: list<scalar|null>,
 *             tags?: scalar|null, // Default: null
 *             public?: bool, // Default: false
 *             default_lifetime?: scalar|null, // Default lifetime of the pool.
 *             provider?: scalar|null, // Overwrite the setting from the default provider for this adapter.
 *             early_expiration_message_bus?: scalar|null,
 *             clearer?: scalar|null,
 *         }>,
 *     },
 *     php_errors?: array{ // PHP errors handling configuration
 *         log?: mixed, // Use the application logger instead of the PHP logger for logging PHP errors. // Default: true
 *         throw?: bool, // Throw PHP errors as \ErrorException instances. // Default: true
 *     },
 *     exceptions?: array<string, array{ // Default: []
 *         log_level?: scalar|null, // The level of log message. Null to let Symfony decide. // Default: null
 *         status_code?: scalar|null, // The status code of the response. Null or 0 to let Symfony decide. // Default: null
 *         log_channel?: scalar|null, // The channel of log message. Null to let Symfony decide. // Default: null
 *     }>,
 *     web_link?: bool|array{ // Web links configuration
 *         enabled?: bool, // Default: false
 *     },
 *     lock?: bool|string|array{ // Lock configuration
 *         enabled?: bool, // Default: true
 *         resources?: array<string, string|list<scalar|null>>,
 *     },
 *     semaphore?: bool|string|array{ // Semaphore configuration
 *         enabled?: bool, // Default: false
 *         resources?: array<string, scalar|null>,
 *     },
 *     messenger?: bool|array{ // Messenger configuration
 *         enabled?: bool, // Default: true
 *         routing?: array<string, array{ // Default: []
 *             senders?: list<scalar|null>,
 *         }>,
 *         serializer?: array{
 *             default_serializer?: scalar|null, // Service id to use as the default serializer for the transports. // Default: "messenger.transport.native_php_serializer"
 *             symfony_serializer?: array{
 *                 format?: scalar|null, // Serialization format for the messenger.transport.symfony_serializer service (which is not the serializer used by default). // Default: "json"
 *                 context?: array<string, mixed>,
 *             },
 *         },
 *         transports?: array<string, string|array{ // Default: []
 *             dsn?: scalar|null,
 *             serializer?: scalar|null, // Service id of a custom serializer to use. // Default: null
 *             options?: list<mixed>,
 *             failure_transport?: scalar|null, // Transport name to send failed messages to (after all retries have failed). // Default: null
 *             retry_strategy?: string|array{
 *                 service?: scalar|null, // Service id to override the retry strategy entirely. // Default: null
 *                 max_retries?: int, // Default: 3
 *                 delay?: int, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float, // If greater than 1, delay will grow exponentially for each retry: this delay = (delay * (multiple ^ retries)). // Default: 2
 *                 max_delay?: int, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float, // Randomness to apply to the delay (between 0 and 1). // Default: 0.1
 *             },
 *             rate_limiter?: scalar|null, // Rate limiter name to use when processing messages. // Default: null
 *         }>,
 *         failure_transport?: scalar|null, // Transport name to send failed messages to (after all retries have failed). // Default: null
 *         stop_worker_on_signals?: list<scalar|null>,
 *         default_bus?: scalar|null, // Default: null
 *         buses?: array<string, array{ // Default: {"messenger.bus.default":{"default_middleware":{"enabled":true,"allow_no_handlers":false,"allow_no_senders":true},"middleware":[]}}
 *             default_middleware?: bool|string|array{
 *                 enabled?: bool, // Default: true
 *                 allow_no_handlers?: bool, // Default: false
 *                 allow_no_senders?: bool, // Default: true
 *             },
 *             middleware?: list<string|array{ // Default: []
 *                 id: scalar|null,
 *                 arguments?: list<mixed>,
 *             }>,
 *         }>,
 *     },
 *     scheduler?: bool|array{ // Scheduler configuration
 *         enabled?: bool, // Default: false
 *     },
 *     disallow_search_engine_index?: bool, // Enabled by default when debug is enabled. // Default: true
 *     http_client?: bool|array{ // HTTP Client configuration
 *         enabled?: bool, // Default: false
 *         max_host_connections?: int, // The maximum number of connections to a single host.
 *         default_options?: array{
 *             headers?: array<string, mixed>,
 *             vars?: array<string, mixed>,
 *             max_redirects?: int, // The maximum number of redirects to follow.
 *             http_version?: scalar|null, // The default HTTP version, typically 1.1 or 2.0, leave to null for the best version.
 *             resolve?: array<string, scalar|null>,
 *             proxy?: scalar|null, // The URL of the proxy to pass requests through or null for automatic detection.
 *             no_proxy?: scalar|null, // A comma separated list of hosts that do not require a proxy to be reached.
 *             timeout?: float, // The idle timeout, defaults to the "default_socket_timeout" ini parameter.
 *             max_duration?: float, // The maximum execution time for the request+response as a whole.
 *             bindto?: scalar|null, // A network interface name, IP address, a host name or a UNIX socket to bind to.
 *             verify_peer?: bool, // Indicates if the peer should be verified in a TLS context.
 *             verify_host?: bool, // Indicates if the host should exist as a certificate common name.
 *             cafile?: scalar|null, // A certificate authority file.
 *             capath?: scalar|null, // A directory that contains multiple certificate authority files.
 *             local_cert?: scalar|null, // A PEM formatted certificate file.
 *             local_pk?: scalar|null, // A private key file.
 *             passphrase?: scalar|null, // The passphrase used to encrypt the "local_pk" file.
 *             ciphers?: scalar|null, // A list of TLS ciphers separated by colons, commas or spaces (e.g. "RC3-SHA:TLS13-AES-128-GCM-SHA256"...)
 *             peer_fingerprint?: array{ // Associative array: hashing algorithm => hash(es).
 *                 sha1?: mixed,
 *                 pin-sha256?: mixed,
 *                 md5?: mixed,
 *             },
 *             crypto_method?: scalar|null, // The minimum version of TLS to accept; must be one of STREAM_CRYPTO_METHOD_TLSv*_CLIENT constants.
 *             extra?: array<string, mixed>,
 *             rate_limiter?: scalar|null, // Rate limiter name to use for throttling requests. // Default: null
 *             caching?: bool|array{ // Caching configuration.
 *                 enabled?: bool, // Default: false
 *                 cache_pool?: string, // The taggable cache pool to use for storing the responses. // Default: "cache.http_client"
 *                 shared?: bool, // Indicates whether the cache is shared (public) or private. // Default: true
 *                 max_ttl?: int, // The maximum TTL (in seconds) allowed for cached responses. Null means no cap. // Default: null
 *             },
 *             retry_failed?: bool|array{
 *                 enabled?: bool, // Default: false
 *                 retry_strategy?: scalar|null, // service id to override the retry strategy. // Default: null
 *                 http_codes?: array<string, array{ // Default: []
 *                     code?: int,
 *                     methods?: list<string>,
 *                 }>,
 *                 max_retries?: int, // Default: 3
 *                 delay?: int, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float, // If greater than 1, delay will grow exponentially for each retry: delay * (multiple ^ retries). // Default: 2
 *                 max_delay?: int, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float, // Randomness in percent (between 0 and 1) to apply to the delay. // Default: 0.1
 *             },
 *         },
 *         mock_response_factory?: scalar|null, // The id of the service that should generate mock responses. It should be either an invokable or an iterable.
 *         scoped_clients?: array<string, string|array{ // Default: []
 *             scope?: scalar|null, // The regular expression that the request URL must match before adding the other options. When none is provided, the base URI is used instead.
 *             base_uri?: scalar|null, // The URI to resolve relative URLs, following rules in RFC 3985, section 2.
 *             auth_basic?: scalar|null, // An HTTP Basic authentication "username:password".
 *             auth_bearer?: scalar|null, // A token enabling HTTP Bearer authorization.
 *             auth_ntlm?: scalar|null, // A "username:password" pair to use Microsoft NTLM authentication (requires the cURL extension).
 *             query?: array<string, scalar|null>,
 *             headers?: array<string, mixed>,
 *             max_redirects?: int, // The maximum number of redirects to follow.
 *             http_version?: scalar|null, // The default HTTP version, typically 1.1 or 2.0, leave to null for the best version.
 *             resolve?: array<string, scalar|null>,
 *             proxy?: scalar|null, // The URL of the proxy to pass requests through or null for automatic detection.
 *             no_proxy?: scalar|null, // A comma separated list of hosts that do not require a proxy to be reached.
 *             timeout?: float, // The idle timeout, defaults to the "default_socket_timeout" ini parameter.
 *             max_duration?: float, // The maximum execution time for the request+response as a whole.
 *             bindto?: scalar|null, // A network interface name, IP address, a host name or a UNIX socket to bind to.
 *             verify_peer?: bool, // Indicates if the peer should be verified in a TLS context.
 *             verify_host?: bool, // Indicates if the host should exist as a certificate common name.
 *             cafile?: scalar|null, // A certificate authority file.
 *             capath?: scalar|null, // A directory that contains multiple certificate authority files.
 *             local_cert?: scalar|null, // A PEM formatted certificate file.
 *             local_pk?: scalar|null, // A private key file.
 *             passphrase?: scalar|null, // The passphrase used to encrypt the "local_pk" file.
 *             ciphers?: scalar|null, // A list of TLS ciphers separated by colons, commas or spaces (e.g. "RC3-SHA:TLS13-AES-128-GCM-SHA256"...).
 *             peer_fingerprint?: array{ // Associative array: hashing algorithm => hash(es).
 *                 sha1?: mixed,
 *                 pin-sha256?: mixed,
 *                 md5?: mixed,
 *             },
 *             crypto_method?: scalar|null, // The minimum version of TLS to accept; must be one of STREAM_CRYPTO_METHOD_TLSv*_CLIENT constants.
 *             extra?: array<string, mixed>,
 *             rate_limiter?: scalar|null, // Rate limiter name to use for throttling requests. // Default: null
 *             caching?: bool|array{ // Caching configuration.
 *                 enabled?: bool, // Default: false
 *                 cache_pool?: string, // The taggable cache pool to use for storing the responses. // Default: "cache.http_client"
 *                 shared?: bool, // Indicates whether the cache is shared (public) or private. // Default: true
 *                 max_ttl?: int, // The maximum TTL (in seconds) allowed for cached responses. Null means no cap. // Default: null
 *             },
 *             retry_failed?: bool|array{
 *                 enabled?: bool, // Default: false
 *                 retry_strategy?: scalar|null, // service id to override the retry strategy. // Default: null
 *                 http_codes?: array<string, array{ // Default: []
 *                     code?: int,
 *                     methods?: list<string>,
 *                 }>,
 *                 max_retries?: int, // Default: 3
 *                 delay?: int, // Time in ms to delay (or the initial value when multiplier is used). // Default: 1000
 *                 multiplier?: float, // If greater than 1, delay will grow exponentially for each retry: delay * (multiple ^ retries). // Default: 2
 *                 max_delay?: int, // Max time in ms that a retry should ever be delayed (0 = infinite). // Default: 0
 *                 jitter?: float, // Randomness in percent (between 0 and 1) to apply to the delay. // Default: 0.1
 *             },
 *         }>,
 *     },
 *     mailer?: bool|array{ // Mailer configuration
 *         enabled?: bool, // Default: true
 *         message_bus?: scalar|null, // The message bus to use. Defaults to the default bus if the Messenger component is installed. // Default: null
 *         dsn?: scalar|null, // Default: null
 *         transports?: array<string, scalar|null>,
 *         envelope?: array{ // Mailer Envelope configuration
 *             sender?: scalar|null,
 *             recipients?: list<scalar|null>,
 *             allowed_recipients?: list<scalar|null>,
 *         },
 *         headers?: array<string, string|array{ // Default: []
 *             value?: mixed,
 *         }>,
 *         dkim_signer?: bool|array{ // DKIM signer configuration
 *             enabled?: bool, // Default: false
 *             key?: scalar|null, // Key content, or path to key (in PEM format with the `file://` prefix) // Default: ""
 *             domain?: scalar|null, // Default: ""
 *             select?: scalar|null, // Default: ""
 *             passphrase?: scalar|null, // The private key passphrase // Default: ""
 *             options?: array<string, mixed>,
 *         },
 *         smime_signer?: bool|array{ // S/MIME signer configuration
 *             enabled?: bool, // Default: false
 *             key?: scalar|null, // Path to key (in PEM format) // Default: ""
 *             certificate?: scalar|null, // Path to certificate (in PEM format without the `file://` prefix) // Default: ""
 *             passphrase?: scalar|null, // The private key passphrase // Default: null
 *             extra_certificates?: scalar|null, // Default: null
 *             sign_options?: int, // Default: null
 *         },
 *         smime_encrypter?: bool|array{ // S/MIME encrypter configuration
 *             enabled?: bool, // Default: false
 *             repository?: scalar|null, // S/MIME certificate repository service. This service shall implement the `Symfony\Component\Mailer\EventListener\SmimeCertificateRepositoryInterface`. // Default: ""
 *             cipher?: int, // A set of algorithms used to encrypt the message // Default: null
 *         },
 *     },
 *     secrets?: bool|array{
 *         enabled?: bool, // Default: true
 *         vault_directory?: scalar|null, // Default: "%kernel.project_dir%/config/secrets/%kernel.runtime_environment%"
 *         local_dotenv_file?: scalar|null, // Default: "%kernel.project_dir%/.env.%kernel.runtime_environment%.local"
 *         decryption_env_var?: scalar|null, // Default: "base64:default::SYMFONY_DECRYPTION_SECRET"
 *     },
 *     notifier?: bool|array{ // Notifier configuration
 *         enabled?: bool, // Default: false
 *         message_bus?: scalar|null, // The message bus to use. Defaults to the default bus if the Messenger component is installed. // Default: null
 *         chatter_transports?: array<string, scalar|null>,
 *         texter_transports?: array<string, scalar|null>,
 *         notification_on_failed_messages?: bool, // Default: false
 *         channel_policy?: array<string, string|list<scalar|null>>,
 *         admin_recipients?: list<array{ // Default: []
 *             email?: scalar|null,
 *             phone?: scalar|null, // Default: ""
 *         }>,
 *     },
 *     rate_limiter?: bool|array{ // Rate limiter configuration
 *         enabled?: bool, // Default: true
 *         limiters?: array<string, array{ // Default: []
 *             lock_factory?: scalar|null, // The service ID of the lock factory used by this limiter (or null to disable locking). // Default: "auto"
 *             cache_pool?: scalar|null, // The cache pool to use for storing the current limiter state. // Default: "cache.rate_limiter"
 *             storage_service?: scalar|null, // The service ID of a custom storage implementation, this precedes any configured "cache_pool". // Default: null
 *             policy: "fixed_window"|"token_bucket"|"sliding_window"|"compound"|"no_limit", // The algorithm to be used by this limiter.
 *             limiters?: list<scalar|null>,
 *             limit?: int, // The maximum allowed hits in a fixed interval or burst.
 *             interval?: scalar|null, // Configures the fixed interval if "policy" is set to "fixed_window" or "sliding_window". The value must be a number followed by "second", "minute", "hour", "day", "week" or "month" (or their plural equivalent).
 *             rate?: array{ // Configures the fill rate if "policy" is set to "token_bucket".
 *                 interval?: scalar|null, // Configures the rate interval. The value must be a number followed by "second", "minute", "hour", "day", "week" or "month" (or their plural equivalent).
 *                 amount?: int, // Amount of tokens to add each interval. // Default: 1
 *             },
 *         }>,
 *     },
 *     uid?: bool|array{ // Uid configuration
 *         enabled?: bool, // Default: true
 *         default_uuid_version?: 7|6|4|1, // Default: 7
 *         name_based_uuid_version?: 5|3, // Default: 5
 *         name_based_uuid_namespace?: scalar|null,
 *         time_based_uuid_version?: 7|6|1, // Default: 7
 *         time_based_uuid_node?: scalar|null,
 *     },
 *     html_sanitizer?: bool|array{ // HtmlSanitizer configuration
 *         enabled?: bool, // Default: true
 *         sanitizers?: array<string, array{ // Default: []
 *             allow_safe_elements?: bool, // Allows "safe" elements and attributes. // Default: false
 *             allow_static_elements?: bool, // Allows all static elements and attributes from the W3C Sanitizer API standard. // Default: false
 *             allow_elements?: array<string, mixed>,
 *             block_elements?: list<string>,
 *             drop_elements?: list<string>,
 *             allow_attributes?: array<string, mixed>,
 *             drop_attributes?: array<string, mixed>,
 *             force_attributes?: array<string, array<string, string>>,
 *             force_https_urls?: bool, // Transforms URLs using the HTTP scheme to use the HTTPS scheme instead. // Default: false
 *             allowed_link_schemes?: list<string>,
 *             allowed_link_hosts?: list<string>|null,
 *             allow_relative_links?: bool, // Allows relative URLs to be used in links href attributes. // Default: false
 *             allowed_media_schemes?: list<string>,
 *             allowed_media_hosts?: list<string>|null,
 *             allow_relative_medias?: bool, // Allows relative URLs to be used in media source attributes (img, audio, video, ...). // Default: false
 *             with_attribute_sanitizers?: list<string>,
 *             without_attribute_sanitizers?: list<string>,
 *             max_input_length?: int, // The maximum length allowed for the sanitized input. // Default: 0
 *         }>,
 *     },
 *     webhook?: bool|array{ // Webhook configuration
 *         enabled?: bool, // Default: false
 *         message_bus?: scalar|null, // The message bus to use. // Default: "messenger.default_bus"
 *         routing?: array<string, array{ // Default: []
 *             service: scalar|null,
 *             secret?: scalar|null, // Default: ""
 *         }>,
 *     },
 *     remote-event?: bool|array{ // RemoteEvent configuration
 *         enabled?: bool, // Default: false
 *     },
 *     json_streamer?: bool|array{ // JSON streamer configuration
 *         enabled?: bool, // Default: false
 *     },
 * }
 * @psalm-type SecurityConfig = array{
 *     access_denied_url?: scalar|null, // Default: null
 *     session_fixation_strategy?: "none"|"migrate"|"invalidate", // Default: "migrate"
 *     hide_user_not_found?: bool, // Deprecated: The "hide_user_not_found" option is deprecated and will be removed in 8.0. Use the "expose_security_errors" option instead.
 *     expose_security_errors?: \Symfony\Component\Security\Http\Authentication\ExposeSecurityLevel::None|\Symfony\Component\Security\Http\Authentication\ExposeSecurityLevel::AccountStatus|\Symfony\Component\Security\Http\Authentication\ExposeSecurityLevel::All, // Default: "none"
 *     erase_credentials?: bool, // Default: true
 *     access_decision_manager?: array{
 *         strategy?: "affirmative"|"consensus"|"unanimous"|"priority",
 *         service?: scalar|null,
 *         strategy_service?: scalar|null,
 *         allow_if_all_abstain?: bool, // Default: false
 *         allow_if_equal_granted_denied?: bool, // Default: true
 *     },
 *     password_hashers?: array<string, string|array{ // Default: []
 *         algorithm?: scalar|null,
 *         migrate_from?: list<scalar|null>,
 *         hash_algorithm?: scalar|null, // Name of hashing algorithm for PBKDF2 (i.e. sha256, sha512, etc..) See hash_algos() for a list of supported algorithms. // Default: "sha512"
 *         key_length?: scalar|null, // Default: 40
 *         ignore_case?: bool, // Default: false
 *         encode_as_base64?: bool, // Default: true
 *         iterations?: scalar|null, // Default: 5000
 *         cost?: int, // Default: null
 *         memory_cost?: scalar|null, // Default: null
 *         time_cost?: scalar|null, // Default: null
 *         id?: scalar|null,
 *     }>,
 *     providers?: array<string, array{ // Default: []
 *         id?: scalar|null,
 *         chain?: array{
 *             providers?: list<scalar|null>,
 *         },
 *         memory?: array{
 *             users?: array<string, array{ // Default: []
 *                 password?: scalar|null, // Default: null
 *                 roles?: list<scalar|null>,
 *             }>,
 *         },
 *         ldap?: array{
 *             service: scalar|null,
 *             base_dn: scalar|null,
 *             search_dn?: scalar|null, // Default: null
 *             search_password?: scalar|null, // Default: null
 *             extra_fields?: list<scalar|null>,
 *             default_roles?: list<scalar|null>,
 *             role_fetcher?: scalar|null, // Default: null
 *             uid_key?: scalar|null, // Default: "sAMAccountName"
 *             filter?: scalar|null, // Default: "({uid_key}={user_identifier})"
 *             password_attribute?: scalar|null, // Default: null
 *         },
 *         entity?: array{
 *             class: scalar|null, // The full entity class name of your user class.
 *             property?: scalar|null, // Default: null
 *             manager_name?: scalar|null, // Default: null
 *         },
 *     }>,
 *     firewalls: array<string, array{ // Default: []
 *         pattern?: scalar|null,
 *         host?: scalar|null,
 *         methods?: list<scalar|null>,
 *         security?: bool, // Default: true
 *         user_checker?: scalar|null, // The UserChecker to use when authenticating users in this firewall. // Default: "security.user_checker"
 *         request_matcher?: scalar|null,
 *         access_denied_url?: scalar|null,
 *         access_denied_handler?: scalar|null,
 *         entry_point?: scalar|null, // An enabled authenticator name or a service id that implements "Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface".
 *         provider?: scalar|null,
 *         stateless?: bool, // Default: false
 *         lazy?: bool, // Default: false
 *         context?: scalar|null,
 *         logout?: array{
 *             enable_csrf?: bool|null, // Default: null
 *             csrf_token_id?: scalar|null, // Default: "logout"
 *             csrf_parameter?: scalar|null, // Default: "_csrf_token"
 *             csrf_token_manager?: scalar|null,
 *             path?: scalar|null, // Default: "/logout"
 *             target?: scalar|null, // Default: "/"
 *             invalidate_session?: bool, // Default: true
 *             clear_site_data?: list<"*"|"cache"|"cookies"|"storage"|"executionContexts">,
 *             delete_cookies?: array<string, array{ // Default: []
 *                 path?: scalar|null, // Default: null
 *                 domain?: scalar|null, // Default: null
 *                 secure?: scalar|null, // Default: false
 *                 samesite?: scalar|null, // Default: null
 *                 partitioned?: scalar|null, // Default: false
 *             }>,
 *         },
 *         switch_user?: array{
 *             provider?: scalar|null,
 *             parameter?: scalar|null, // Default: "_switch_user"
 *             role?: scalar|null, // Default: "ROLE_ALLOWED_TO_SWITCH"
 *             target_route?: scalar|null, // Default: null
 *         },
 *         required_badges?: list<scalar|null>,
 *         custom_authenticators?: list<scalar|null>,
 *         login_throttling?: array{
 *             limiter?: scalar|null, // A service id implementing "Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface".
 *             max_attempts?: int, // Default: 5
 *             interval?: scalar|null, // Default: "1 minute"
 *             lock_factory?: scalar|null, // The service ID of the lock factory used by the login rate limiter (or null to disable locking). // Default: null
 *             cache_pool?: string, // The cache pool to use for storing the limiter state // Default: "cache.rate_limiter"
 *             storage_service?: string, // The service ID of a custom storage implementation, this precedes any configured "cache_pool" // Default: null
 *         },
 *         two_factor?: array{
 *             check_path?: scalar|null, // Default: "/2fa_check"
 *             post_only?: bool, // Default: true
 *             auth_form_path?: scalar|null, // Default: "/2fa"
 *             always_use_default_target_path?: bool, // Default: false
 *             default_target_path?: scalar|null, // Default: "/"
 *             success_handler?: scalar|null, // Default: null
 *             failure_handler?: scalar|null, // Default: null
 *             authentication_required_handler?: scalar|null, // Default: null
 *             auth_code_parameter_name?: scalar|null, // Default: "_auth_code"
 *             trusted_parameter_name?: scalar|null, // Default: "_trusted"
 *             remember_me_sets_trusted?: scalar|null, // Default: false
 *             multi_factor?: bool, // Default: false
 *             prepare_on_login?: bool, // Default: false
 *             prepare_on_access_denied?: bool, // Default: false
 *             enable_csrf?: scalar|null, // Default: false
 *             csrf_parameter?: scalar|null, // Default: "_csrf_token"
 *             csrf_token_id?: scalar|null, // Default: "two_factor"
 *             csrf_header?: scalar|null, // Default: null
 *             csrf_token_manager?: scalar|null, // Default: "scheb_two_factor.csrf_token_manager"
 *             provider?: scalar|null, // Default: null
 *         },
 *         x509?: array{
 *             provider?: scalar|null,
 *             user?: scalar|null, // Default: "SSL_CLIENT_S_DN_Email"
 *             credentials?: scalar|null, // Default: "SSL_CLIENT_S_DN"
 *             user_identifier?: scalar|null, // Default: "emailAddress"
 *         },
 *         remote_user?: array{
 *             provider?: scalar|null,
 *             user?: scalar|null, // Default: "REMOTE_USER"
 *         },
 *         login_link?: array{
 *             check_route: scalar|null, // Route that will validate the login link - e.g. "app_login_link_verify".
 *             check_post_only?: scalar|null, // If true, only HTTP POST requests to "check_route" will be handled by the authenticator. // Default: false
 *             signature_properties: list<scalar|null>,
 *             lifetime?: int, // The lifetime of the login link in seconds. // Default: 600
 *             max_uses?: int, // Max number of times a login link can be used - null means unlimited within lifetime. // Default: null
 *             used_link_cache?: scalar|null, // Cache service id used to expired links of max_uses is set.
 *             success_handler?: scalar|null, // A service id that implements Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface.
 *             failure_handler?: scalar|null, // A service id that implements Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface.
 *             provider?: scalar|null, // The user provider to load users from.
 *             secret?: scalar|null, // Default: "%kernel.secret%"
 *             always_use_default_target_path?: bool, // Default: false
 *             default_target_path?: scalar|null, // Default: "/"
 *             login_path?: scalar|null, // Default: "/login"
 *             target_path_parameter?: scalar|null, // Default: "_target_path"
 *             use_referer?: bool, // Default: false
 *             failure_path?: scalar|null, // Default: null
 *             failure_forward?: bool, // Default: false
 *             failure_path_parameter?: scalar|null, // Default: "_failure_path"
 *         },
 *         form_login?: array{
 *             provider?: scalar|null,
 *             remember_me?: bool, // Default: true
 *             success_handler?: scalar|null,
 *             failure_handler?: scalar|null,
 *             check_path?: scalar|null, // Default: "/login_check"
 *             use_forward?: bool, // Default: false
 *             login_path?: scalar|null, // Default: "/login"
 *             username_parameter?: scalar|null, // Default: "_username"
 *             password_parameter?: scalar|null, // Default: "_password"
 *             csrf_parameter?: scalar|null, // Default: "_csrf_token"
 *             csrf_token_id?: scalar|null, // Default: "authenticate"
 *             enable_csrf?: bool, // Default: false
 *             post_only?: bool, // Default: true
 *             form_only?: bool, // Default: false
 *             always_use_default_target_path?: bool, // Default: false
 *             default_target_path?: scalar|null, // Default: "/"
 *             target_path_parameter?: scalar|null, // Default: "_target_path"
 *             use_referer?: bool, // Default: false
 *             failure_path?: scalar|null, // Default: null
 *             failure_forward?: bool, // Default: false
 *             failure_path_parameter?: scalar|null, // Default: "_failure_path"
 *         },
 *         form_login_ldap?: array{
 *             provider?: scalar|null,
 *             remember_me?: bool, // Default: true
 *             success_handler?: scalar|null,
 *             failure_handler?: scalar|null,
 *             check_path?: scalar|null, // Default: "/login_check"
 *             use_forward?: bool, // Default: false
 *             login_path?: scalar|null, // Default: "/login"
 *             username_parameter?: scalar|null, // Default: "_username"
 *             password_parameter?: scalar|null, // Default: "_password"
 *             csrf_parameter?: scalar|null, // Default: "_csrf_token"
 *             csrf_token_id?: scalar|null, // Default: "authenticate"
 *             enable_csrf?: bool, // Default: false
 *             post_only?: bool, // Default: true
 *             form_only?: bool, // Default: false
 *             always_use_default_target_path?: bool, // Default: false
 *             default_target_path?: scalar|null, // Default: "/"
 *             target_path_parameter?: scalar|null, // Default: "_target_path"
 *             use_referer?: bool, // Default: false
 *             failure_path?: scalar|null, // Default: null
 *             failure_forward?: bool, // Default: false
 *             failure_path_parameter?: scalar|null, // Default: "_failure_path"
 *             service?: scalar|null, // Default: "ldap"
 *             dn_string?: scalar|null, // Default: "{user_identifier}"
 *             query_string?: scalar|null,
 *             search_dn?: scalar|null, // Default: ""
 *             search_password?: scalar|null, // Default: ""
 *         },
 *         json_login?: array{
 *             provider?: scalar|null,
 *             remember_me?: bool, // Default: true
 *             success_handler?: scalar|null,
 *             failure_handler?: scalar|null,
 *             check_path?: scalar|null, // Default: "/login_check"
 *             use_forward?: bool, // Default: false
 *             login_path?: scalar|null, // Default: "/login"
 *             username_path?: scalar|null, // Default: "username"
 *             password_path?: scalar|null, // Default: "password"
 *         },
 *         json_login_ldap?: array{
 *             provider?: scalar|null,
 *             remember_me?: bool, // Default: true
 *             success_handler?: scalar|null,
 *             failure_handler?: scalar|null,
 *             check_path?: scalar|null, // Default: "/login_check"
 *             use_forward?: bool, // Default: false
 *             login_path?: scalar|null, // Default: "/login"
 *             username_path?: scalar|null, // Default: "username"
 *             password_path?: scalar|null, // Default: "password"
 *             service?: scalar|null, // Default: "ldap"
 *             dn_string?: scalar|null, // Default: "{user_identifier}"
 *             query_string?: scalar|null,
 *             search_dn?: scalar|null, // Default: ""
 *             search_password?: scalar|null, // Default: ""
 *         },
 *         access_token?: array{
 *             provider?: scalar|null,
 *             remember_me?: bool, // Default: true
 *             success_handler?: scalar|null,
 *             failure_handler?: scalar|null,
 *             realm?: scalar|null, // Default: null
 *             token_extractors?: list<scalar|null>,
 *             token_handler: string|array{
 *                 id?: scalar|null,
 *                 oidc_user_info?: string|array{
 *                     base_uri: scalar|null, // Base URI of the userinfo endpoint on the OIDC server, or the OIDC server URI to use the discovery (require "discovery" to be configured).
 *                     discovery?: array{ // Enable the OIDC discovery.
 *                         cache?: array{
 *                             id: scalar|null, // Cache service id to use to cache the OIDC discovery configuration.
 *                         },
 *                     },
 *                     claim?: scalar|null, // Claim which contains the user identifier (e.g. sub, email, etc.). // Default: "sub"
 *                     client?: scalar|null, // HttpClient service id to use to call the OIDC server.
 *                 },
 *                 oidc?: array{
 *                     discovery?: array{ // Enable the OIDC discovery.
 *                         base_uri: list<scalar|null>,
 *                         cache?: array{
 *                             id: scalar|null, // Cache service id to use to cache the OIDC discovery configuration.
 *                         },
 *                     },
 *                     claim?: scalar|null, // Claim which contains the user identifier (e.g.: sub, email..). // Default: "sub"
 *                     audience: scalar|null, // Audience set in the token, for validation purpose.
 *                     issuers: list<scalar|null>,
 *                     algorithm?: array<mixed>,
 *                     algorithms: list<scalar|null>,
 *                     key?: scalar|null, // Deprecated: The "key" option is deprecated and will be removed in 8.0. Use the "keyset" option instead. // JSON-encoded JWK used to sign the token (must contain a "kty" key).
 *                     keyset?: scalar|null, // JSON-encoded JWKSet used to sign the token (must contain a list of valid public keys).
 *                     encryption?: bool|array{
 *                         enabled?: bool, // Default: false
 *                         enforce?: bool, // When enabled, the token shall be encrypted. // Default: false
 *                         algorithms: list<scalar|null>,
 *                         keyset: scalar|null, // JSON-encoded JWKSet used to decrypt the token (must contain a list of valid private keys).
 *                     },
 *                 },
 *                 cas?: array{
 *                     validation_url: scalar|null, // CAS server validation URL
 *                     prefix?: scalar|null, // CAS prefix // Default: "cas"
 *                     http_client?: scalar|null, // HTTP Client service // Default: null
 *                 },
 *                 oauth2?: scalar|null,
 *             },
 *         },
 *         http_basic?: array{
 *             provider?: scalar|null,
 *             realm?: scalar|null, // Default: "Secured Area"
 *         },
 *         http_basic_ldap?: array{
 *             provider?: scalar|null,
 *             realm?: scalar|null, // Default: "Secured Area"
 *             service?: scalar|null, // Default: "ldap"
 *             dn_string?: scalar|null, // Default: "{user_identifier}"
 *             query_string?: scalar|null,
 *             search_dn?: scalar|null, // Default: ""
 *             search_password?: scalar|null, // Default: ""
 *         },
 *         remember_me?: array{
 *             secret?: scalar|null, // Default: "%kernel.secret%"
 *             service?: scalar|null,
 *             user_providers?: list<scalar|null>,
 *             catch_exceptions?: bool, // Default: true
 *             signature_properties?: list<scalar|null>,
 *             token_provider?: string|array{
 *                 service?: scalar|null, // The service ID of a custom remember-me token provider.
 *                 doctrine?: bool|array{
 *                     enabled?: bool, // Default: false
 *                     connection?: scalar|null, // Default: null
 *                 },
 *             },
 *             token_verifier?: scalar|null, // The service ID of a custom rememberme token verifier.
 *             name?: scalar|null, // Default: "REMEMBERME"
 *             lifetime?: int, // Default: 31536000
 *             path?: scalar|null, // Default: "/"
 *             domain?: scalar|null, // Default: null
 *             secure?: true|false|"auto", // Default: null
 *             httponly?: bool, // Default: true
 *             samesite?: null|"lax"|"strict"|"none", // Default: null
 *             always_remember_me?: bool, // Default: false
 *             remember_me_parameter?: scalar|null, // Default: "_remember_me"
 *         },
 *     }>,
 *     access_control?: list<array{ // Default: []
 *         request_matcher?: scalar|null, // Default: null
 *         requires_channel?: scalar|null, // Default: null
 *         path?: scalar|null, // Use the urldecoded format. // Default: null
 *         host?: scalar|null, // Default: null
 *         port?: int, // Default: null
 *         ips?: list<scalar|null>,
 *         attributes?: array<string, scalar|null>,
 *         route?: scalar|null, // Default: null
 *         methods?: list<scalar|null>,
 *         allow_if?: scalar|null, // Default: null
 *         roles?: list<scalar|null>,
 *     }>,
 *     role_hierarchy?: array<string, string|list<scalar|null>>,
 * }
 * @psalm-type TwigConfig = array{
 *     form_themes?: list<scalar|null>,
 *     globals?: array<string, array{ // Default: []
 *         id?: scalar|null,
 *         type?: scalar|null,
 *         value?: mixed,
 *     }>,
 *     autoescape_service?: scalar|null, // Default: null
 *     autoescape_service_method?: scalar|null, // Default: null
 *     base_template_class?: scalar|null, // Deprecated: The child node "base_template_class" at path "twig.base_template_class" is deprecated.
 *     cache?: scalar|null, // Default: true
 *     charset?: scalar|null, // Default: "%kernel.charset%"
 *     debug?: bool, // Default: "%kernel.debug%"
 *     strict_variables?: bool, // Default: "%kernel.debug%"
 *     auto_reload?: scalar|null,
 *     optimizations?: int,
 *     default_path?: scalar|null, // The default path used to load templates. // Default: "%kernel.project_dir%/templates"
 *     file_name_pattern?: list<scalar|null>,
 *     paths?: array<string, mixed>,
 *     date?: array{ // The default format options used by the date filter.
 *         format?: scalar|null, // Default: "F j, Y H:i"
 *         interval_format?: scalar|null, // Default: "%d days"
 *         timezone?: scalar|null, // The timezone used when formatting dates, when set to null, the timezone returned by date_default_timezone_get() is used. // Default: null
 *     },
 *     number_format?: array{ // The default format options for the number_format filter.
 *         decimals?: int, // Default: 0
 *         decimal_point?: scalar|null, // Default: "."
 *         thousands_separator?: scalar|null, // Default: ","
 *     },
 *     mailer?: array{
 *         html_to_text_converter?: scalar|null, // A service implementing the "Symfony\Component\Mime\HtmlToTextConverter\HtmlToTextConverterInterface". // Default: null
 *     },
 * }
 * @psalm-type TwigExtraConfig = array{
 *     cache?: bool|array{
 *         enabled?: bool, // Default: false
 *     },
 *     html?: bool|array{
 *         enabled?: bool, // Default: false
 *     },
 *     markdown?: bool|array{
 *         enabled?: bool, // Default: false
 *     },
 *     intl?: bool|array{
 *         enabled?: bool, // Default: false
 *     },
 *     cssinliner?: bool|array{
 *         enabled?: bool, // Default: false
 *     },
 *     inky?: bool|array{
 *         enabled?: bool, // Default: false
 *     },
 *     string?: bool|array{
 *         enabled?: bool, // Default: true
 *     },
 *     commonmark?: array{
 *         renderer?: array{ // Array of options for rendering HTML.
 *             block_separator?: scalar|null,
 *             inner_separator?: scalar|null,
 *             soft_break?: scalar|null,
 *         },
 *         html_input?: "strip"|"allow"|"escape", // How to handle HTML input.
 *         allow_unsafe_links?: bool, // Remove risky link and image URLs by setting this to false. // Default: true
 *         max_nesting_level?: int, // The maximum nesting level for blocks. // Default: 9223372036854775807
 *         max_delimiters_per_line?: int, // The maximum number of strong/emphasis delimiters per line. // Default: 9223372036854775807
 *         slug_normalizer?: array{ // Array of options for configuring how URL-safe slugs are created.
 *             instance?: mixed,
 *             max_length?: int, // Default: 255
 *             unique?: mixed,
 *         },
 *         commonmark?: array{ // Array of options for configuring the CommonMark core extension.
 *             enable_em?: bool, // Default: true
 *             enable_strong?: bool, // Default: true
 *             use_asterisk?: bool, // Default: true
 *             use_underscore?: bool, // Default: true
 *             unordered_list_markers?: list<scalar|null>,
 *         },
 *         ...<mixed>
 *     },
 * }
 * @psalm-type MonologConfig = array{
 *     use_microseconds?: scalar|null, // Default: true
 *     channels?: list<scalar|null>,
 *     handlers?: array<string, array{ // Default: []
 *         type: scalar|null,
 *         id?: scalar|null,
 *         enabled?: bool, // Default: true
 *         priority?: scalar|null, // Default: 0
 *         level?: scalar|null, // Default: "DEBUG"
 *         bubble?: bool, // Default: true
 *         interactive_only?: bool, // Default: false
 *         app_name?: scalar|null, // Default: null
 *         fill_extra_context?: bool, // Default: false
 *         include_stacktraces?: bool, // Default: false
 *         process_psr_3_messages?: array{
 *             enabled?: bool|null, // Default: null
 *             date_format?: scalar|null,
 *             remove_used_context_fields?: bool,
 *         },
 *         path?: scalar|null, // Default: "%kernel.logs_dir%/%kernel.environment%.log"
 *         file_permission?: scalar|null, // Default: null
 *         use_locking?: bool, // Default: false
 *         filename_format?: scalar|null, // Default: "{filename}-{date}"
 *         date_format?: scalar|null, // Default: "Y-m-d"
 *         ident?: scalar|null, // Default: false
 *         logopts?: scalar|null, // Default: 1
 *         facility?: scalar|null, // Default: "user"
 *         max_files?: scalar|null, // Default: 0
 *         action_level?: scalar|null, // Default: "WARNING"
 *         activation_strategy?: scalar|null, // Default: null
 *         stop_buffering?: bool, // Default: true
 *         passthru_level?: scalar|null, // Default: null
 *         excluded_404s?: list<scalar|null>,
 *         excluded_http_codes?: list<array{ // Default: []
 *             code?: scalar|null,
 *             urls?: list<scalar|null>,
 *         }>,
 *         accepted_levels?: list<scalar|null>,
 *         min_level?: scalar|null, // Default: "DEBUG"
 *         max_level?: scalar|null, // Default: "EMERGENCY"
 *         buffer_size?: scalar|null, // Default: 0
 *         flush_on_overflow?: bool, // Default: false
 *         handler?: scalar|null,
 *         url?: scalar|null,
 *         exchange?: scalar|null,
 *         exchange_name?: scalar|null, // Default: "log"
 *         room?: scalar|null,
 *         message_format?: scalar|null, // Default: "text"
 *         api_version?: scalar|null, // Default: null
 *         channel?: scalar|null, // Default: null
 *         bot_name?: scalar|null, // Default: "Monolog"
 *         use_attachment?: scalar|null, // Default: true
 *         use_short_attachment?: scalar|null, // Default: false
 *         include_extra?: scalar|null, // Default: false
 *         icon_emoji?: scalar|null, // Default: null
 *         webhook_url?: scalar|null,
 *         exclude_fields?: list<scalar|null>,
 *         team?: scalar|null,
 *         notify?: scalar|null, // Default: false
 *         nickname?: scalar|null, // Default: "Monolog"
 *         token?: scalar|null,
 *         region?: scalar|null,
 *         source?: scalar|null,
 *         use_ssl?: bool, // Default: true
 *         user?: mixed,
 *         title?: scalar|null, // Default: null
 *         host?: scalar|null, // Default: null
 *         port?: scalar|null, // Default: 514
 *         config?: list<scalar|null>,
 *         members?: list<scalar|null>,
 *         connection_string?: scalar|null,
 *         timeout?: scalar|null,
 *         time?: scalar|null, // Default: 60
 *         deduplication_level?: scalar|null, // Default: 400
 *         store?: scalar|null, // Default: null
 *         connection_timeout?: scalar|null,
 *         persistent?: bool,
 *         dsn?: scalar|null,
 *         hub_id?: scalar|null, // Default: null
 *         client_id?: scalar|null, // Default: null
 *         auto_log_stacks?: scalar|null, // Default: false
 *         release?: scalar|null, // Default: null
 *         environment?: scalar|null, // Default: null
 *         message_type?: scalar|null, // Default: 0
 *         parse_mode?: scalar|null, // Default: null
 *         disable_webpage_preview?: bool|null, // Default: null
 *         disable_notification?: bool|null, // Default: null
 *         split_long_messages?: bool, // Default: false
 *         delay_between_messages?: bool, // Default: false
 *         topic?: int, // Default: null
 *         factor?: int, // Default: 1
 *         tags?: list<scalar|null>,
 *         console_formater_options?: mixed, // Deprecated: "monolog.handlers..console_formater_options.console_formater_options" is deprecated, use "monolog.handlers..console_formater_options.console_formatter_options" instead.
 *         console_formatter_options?: mixed, // Default: []
 *         formatter?: scalar|null,
 *         nested?: bool, // Default: false
 *         publisher?: string|array{
 *             id?: scalar|null,
 *             hostname?: scalar|null,
 *             port?: scalar|null, // Default: 12201
 *             chunk_size?: scalar|null, // Default: 1420
 *             encoder?: "json"|"compressed_json",
 *         },
 *         mongo?: string|array{
 *             id?: scalar|null,
 *             host?: scalar|null,
 *             port?: scalar|null, // Default: 27017
 *             user?: scalar|null,
 *             pass?: scalar|null,
 *             database?: scalar|null, // Default: "monolog"
 *             collection?: scalar|null, // Default: "logs"
 *         },
 *         mongodb?: string|array{
 *             id?: scalar|null, // ID of a MongoDB\Client service
 *             uri?: scalar|null,
 *             username?: scalar|null,
 *             password?: scalar|null,
 *             database?: scalar|null, // Default: "monolog"
 *             collection?: scalar|null, // Default: "logs"
 *         },
 *         elasticsearch?: string|array{
 *             id?: scalar|null,
 *             hosts?: list<scalar|null>,
 *             host?: scalar|null,
 *             port?: scalar|null, // Default: 9200
 *             transport?: scalar|null, // Default: "Http"
 *             user?: scalar|null, // Default: null
 *             password?: scalar|null, // Default: null
 *         },
 *         index?: scalar|null, // Default: "monolog"
 *         document_type?: scalar|null, // Default: "logs"
 *         ignore_error?: scalar|null, // Default: false
 *         redis?: string|array{
 *             id?: scalar|null,
 *             host?: scalar|null,
 *             password?: scalar|null, // Default: null
 *             port?: scalar|null, // Default: 6379
 *             database?: scalar|null, // Default: 0
 *             key_name?: scalar|null, // Default: "monolog_redis"
 *         },
 *         predis?: string|array{
 *             id?: scalar|null,
 *             host?: scalar|null,
 *         },
 *         from_email?: scalar|null,
 *         to_email?: list<scalar|null>,
 *         subject?: scalar|null,
 *         content_type?: scalar|null, // Default: null
 *         headers?: list<scalar|null>,
 *         mailer?: scalar|null, // Default: null
 *         email_prototype?: string|array{
 *             id: scalar|null,
 *             method?: scalar|null, // Default: null
 *         },
 *         lazy?: bool, // Default: true
 *         verbosity_levels?: array{
 *             VERBOSITY_QUIET?: scalar|null, // Default: "ERROR"
 *             VERBOSITY_NORMAL?: scalar|null, // Default: "WARNING"
 *             VERBOSITY_VERBOSE?: scalar|null, // Default: "NOTICE"
 *             VERBOSITY_VERY_VERBOSE?: scalar|null, // Default: "INFO"
 *             VERBOSITY_DEBUG?: scalar|null, // Default: "DEBUG"
 *         },
 *         channels?: string|array{
 *             type?: scalar|null,
 *             elements?: list<scalar|null>,
 *         },
 *     }>,
 * }
 * @psalm-type DoctrineConfig = array{
 *     dbal?: array{
 *         default_connection?: scalar|null,
 *         types?: array<string, string|array{ // Default: []
 *             class: scalar|null,
 *             commented?: bool, // Deprecated: The doctrine-bundle type commenting features were removed; the corresponding config parameter was deprecated in 2.0 and will be dropped in 3.0.
 *         }>,
 *         driver_schemes?: array<string, scalar|null>,
 *         connections?: array<string, array{ // Default: []
 *             url?: scalar|null, // A URL with connection information; any parameter value parsed from this string will override explicitly set parameters
 *             dbname?: scalar|null,
 *             host?: scalar|null, // Defaults to "localhost" at runtime.
 *             port?: scalar|null, // Defaults to null at runtime.
 *             user?: scalar|null, // Defaults to "root" at runtime.
 *             password?: scalar|null, // Defaults to null at runtime.
 *             override_url?: bool, // Deprecated: The "doctrine.dbal.override_url" configuration key is deprecated.
 *             dbname_suffix?: scalar|null, // Adds the given suffix to the configured database name, this option has no effects for the SQLite platform
 *             application_name?: scalar|null,
 *             charset?: scalar|null,
 *             path?: scalar|null,
 *             memory?: bool,
 *             unix_socket?: scalar|null, // The unix socket to use for MySQL
 *             persistent?: bool, // True to use as persistent connection for the ibm_db2 driver
 *             protocol?: scalar|null, // The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
 *             service?: bool, // True to use SERVICE_NAME as connection parameter instead of SID for Oracle
 *             servicename?: scalar|null, // Overrules dbname parameter if given and used as SERVICE_NAME or SID connection parameter for Oracle depending on the service parameter.
 *             sessionMode?: scalar|null, // The session mode to use for the oci8 driver
 *             server?: scalar|null, // The name of a running database server to connect to for SQL Anywhere.
 *             default_dbname?: scalar|null, // Override the default database (postgres) to connect to for PostgreSQL connexion.
 *             sslmode?: scalar|null, // Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
 *             sslrootcert?: scalar|null, // The name of a file containing SSL certificate authority (CA) certificate(s). If the file exists, the server's certificate will be verified to be signed by one of these authorities.
 *             sslcert?: scalar|null, // The path to the SSL client certificate file for PostgreSQL.
 *             sslkey?: scalar|null, // The path to the SSL client key file for PostgreSQL.
 *             sslcrl?: scalar|null, // The file name of the SSL certificate revocation list for PostgreSQL.
 *             pooled?: bool, // True to use a pooled server with the oci8/pdo_oracle driver
 *             MultipleActiveResultSets?: bool, // Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
 *             use_savepoints?: bool, // Use savepoints for nested transactions
 *             instancename?: scalar|null, // Optional parameter, complete whether to add the INSTANCE_NAME parameter in the connection. It is generally used to connect to an Oracle RAC server to select the name of a particular instance.
 *             connectstring?: scalar|null, // Complete Easy Connect connection descriptor, see https://docs.oracle.com/database/121/NETAG/naming.htm.When using this option, you will still need to provide the user and password parameters, but the other parameters will no longer be used. Note that when using this parameter, the getHost and getPort methods from Doctrine\DBAL\Connection will no longer function as expected.
 *             driver?: scalar|null, // Default: "pdo_mysql"
 *             platform_service?: scalar|null, // Deprecated: The "platform_service" configuration key is deprecated since doctrine-bundle 2.9. DBAL 4 will not support setting a custom platform via connection params anymore.
 *             auto_commit?: bool,
 *             schema_filter?: scalar|null,
 *             logging?: bool, // Default: true
 *             profiling?: bool, // Default: true
 *             profiling_collect_backtrace?: bool, // Enables collecting backtraces when profiling is enabled // Default: false
 *             profiling_collect_schema_errors?: bool, // Enables collecting schema errors when profiling is enabled // Default: true
 *             disable_type_comments?: bool,
 *             server_version?: scalar|null,
 *             idle_connection_ttl?: int, // Default: 600
 *             driver_class?: scalar|null,
 *             wrapper_class?: scalar|null,
 *             keep_slave?: bool, // Deprecated: The "keep_slave" configuration key is deprecated since doctrine-bundle 2.2. Use the "keep_replica" configuration key instead.
 *             keep_replica?: bool,
 *             options?: array<string, mixed>,
 *             mapping_types?: array<string, scalar|null>,
 *             default_table_options?: array<string, scalar|null>,
 *             schema_manager_factory?: scalar|null, // Default: "doctrine.dbal.default_schema_manager_factory"
 *             result_cache?: scalar|null,
 *             slaves?: array<string, array{ // Default: []
 *                 url?: scalar|null, // A URL with connection information; any parameter value parsed from this string will override explicitly set parameters
 *                 dbname?: scalar|null,
 *                 host?: scalar|null, // Defaults to "localhost" at runtime.
 *                 port?: scalar|null, // Defaults to null at runtime.
 *                 user?: scalar|null, // Defaults to "root" at runtime.
 *                 password?: scalar|null, // Defaults to null at runtime.
 *                 override_url?: bool, // Deprecated: The "doctrine.dbal.override_url" configuration key is deprecated.
 *                 dbname_suffix?: scalar|null, // Adds the given suffix to the configured database name, this option has no effects for the SQLite platform
 *                 application_name?: scalar|null,
 *                 charset?: scalar|null,
 *                 path?: scalar|null,
 *                 memory?: bool,
 *                 unix_socket?: scalar|null, // The unix socket to use for MySQL
 *                 persistent?: bool, // True to use as persistent connection for the ibm_db2 driver
 *                 protocol?: scalar|null, // The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
 *                 service?: bool, // True to use SERVICE_NAME as connection parameter instead of SID for Oracle
 *                 servicename?: scalar|null, // Overrules dbname parameter if given and used as SERVICE_NAME or SID connection parameter for Oracle depending on the service parameter.
 *                 sessionMode?: scalar|null, // The session mode to use for the oci8 driver
 *                 server?: scalar|null, // The name of a running database server to connect to for SQL Anywhere.
 *                 default_dbname?: scalar|null, // Override the default database (postgres) to connect to for PostgreSQL connexion.
 *                 sslmode?: scalar|null, // Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
 *                 sslrootcert?: scalar|null, // The name of a file containing SSL certificate authority (CA) certificate(s). If the file exists, the server's certificate will be verified to be signed by one of these authorities.
 *                 sslcert?: scalar|null, // The path to the SSL client certificate file for PostgreSQL.
 *                 sslkey?: scalar|null, // The path to the SSL client key file for PostgreSQL.
 *                 sslcrl?: scalar|null, // The file name of the SSL certificate revocation list for PostgreSQL.
 *                 pooled?: bool, // True to use a pooled server with the oci8/pdo_oracle driver
 *                 MultipleActiveResultSets?: bool, // Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
 *                 use_savepoints?: bool, // Use savepoints for nested transactions
 *                 instancename?: scalar|null, // Optional parameter, complete whether to add the INSTANCE_NAME parameter in the connection. It is generally used to connect to an Oracle RAC server to select the name of a particular instance.
 *                 connectstring?: scalar|null, // Complete Easy Connect connection descriptor, see https://docs.oracle.com/database/121/NETAG/naming.htm.When using this option, you will still need to provide the user and password parameters, but the other parameters will no longer be used. Note that when using this parameter, the getHost and getPort methods from Doctrine\DBAL\Connection will no longer function as expected.
 *             }>,
 *             replicas?: array<string, array{ // Default: []
 *                 url?: scalar|null, // A URL with connection information; any parameter value parsed from this string will override explicitly set parameters
 *                 dbname?: scalar|null,
 *                 host?: scalar|null, // Defaults to "localhost" at runtime.
 *                 port?: scalar|null, // Defaults to null at runtime.
 *                 user?: scalar|null, // Defaults to "root" at runtime.
 *                 password?: scalar|null, // Defaults to null at runtime.
 *                 override_url?: bool, // Deprecated: The "doctrine.dbal.override_url" configuration key is deprecated.
 *                 dbname_suffix?: scalar|null, // Adds the given suffix to the configured database name, this option has no effects for the SQLite platform
 *                 application_name?: scalar|null,
 *                 charset?: scalar|null,
 *                 path?: scalar|null,
 *                 memory?: bool,
 *                 unix_socket?: scalar|null, // The unix socket to use for MySQL
 *                 persistent?: bool, // True to use as persistent connection for the ibm_db2 driver
 *                 protocol?: scalar|null, // The protocol to use for the ibm_db2 driver (default to TCPIP if omitted)
 *                 service?: bool, // True to use SERVICE_NAME as connection parameter instead of SID for Oracle
 *                 servicename?: scalar|null, // Overrules dbname parameter if given and used as SERVICE_NAME or SID connection parameter for Oracle depending on the service parameter.
 *                 sessionMode?: scalar|null, // The session mode to use for the oci8 driver
 *                 server?: scalar|null, // The name of a running database server to connect to for SQL Anywhere.
 *                 default_dbname?: scalar|null, // Override the default database (postgres) to connect to for PostgreSQL connexion.
 *                 sslmode?: scalar|null, // Determines whether or with what priority a SSL TCP/IP connection will be negotiated with the server for PostgreSQL.
 *                 sslrootcert?: scalar|null, // The name of a file containing SSL certificate authority (CA) certificate(s). If the file exists, the server's certificate will be verified to be signed by one of these authorities.
 *                 sslcert?: scalar|null, // The path to the SSL client certificate file for PostgreSQL.
 *                 sslkey?: scalar|null, // The path to the SSL client key file for PostgreSQL.
 *                 sslcrl?: scalar|null, // The file name of the SSL certificate revocation list for PostgreSQL.
 *                 pooled?: bool, // True to use a pooled server with the oci8/pdo_oracle driver
 *                 MultipleActiveResultSets?: bool, // Configuring MultipleActiveResultSets for the pdo_sqlsrv driver
 *                 use_savepoints?: bool, // Use savepoints for nested transactions
 *                 instancename?: scalar|null, // Optional parameter, complete whether to add the INSTANCE_NAME parameter in the connection. It is generally used to connect to an Oracle RAC server to select the name of a particular instance.
 *                 connectstring?: scalar|null, // Complete Easy Connect connection descriptor, see https://docs.oracle.com/database/121/NETAG/naming.htm.When using this option, you will still need to provide the user and password parameters, but the other parameters will no longer be used. Note that when using this parameter, the getHost and getPort methods from Doctrine\DBAL\Connection will no longer function as expected.
 *             }>,
 *         }>,
 *     },
 *     orm?: array{
 *         default_entity_manager?: scalar|null,
 *         auto_generate_proxy_classes?: scalar|null, // Auto generate mode possible values are: "NEVER", "ALWAYS", "FILE_NOT_EXISTS", "EVAL", "FILE_NOT_EXISTS_OR_CHANGED", this option is ignored when the "enable_native_lazy_objects" option is true // Default: false
 *         enable_lazy_ghost_objects?: bool, // Enables the new implementation of proxies based on lazy ghosts instead of using the legacy implementation // Default: true
 *         enable_native_lazy_objects?: bool, // Enables the new native implementation of PHP lazy objects instead of generated proxies // Default: false
 *         proxy_dir?: scalar|null, // Configures the path where generated proxy classes are saved when using non-native lazy objects, this option is ignored when the "enable_native_lazy_objects" option is true // Default: "%kernel.build_dir%/doctrine/orm/Proxies"
 *         proxy_namespace?: scalar|null, // Defines the root namespace for generated proxy classes when using non-native lazy objects, this option is ignored when the "enable_native_lazy_objects" option is true // Default: "Proxies"
 *         controller_resolver?: bool|array{
 *             enabled?: bool, // Default: true
 *             auto_mapping?: bool|null, // Set to false to disable using route placeholders as lookup criteria when the primary key doesn't match the argument name // Default: null
 *             evict_cache?: bool, // Set to true to fetch the entity from the database instead of using the cache, if any // Default: false
 *         },
 *         entity_managers?: array<string, array{ // Default: []
 *             query_cache_driver?: string|array{
 *                 type?: scalar|null, // Default: null
 *                 id?: scalar|null,
 *                 pool?: scalar|null,
 *             },
 *             metadata_cache_driver?: string|array{
 *                 type?: scalar|null, // Default: null
 *                 id?: scalar|null,
 *                 pool?: scalar|null,
 *             },
 *             result_cache_driver?: string|array{
 *                 type?: scalar|null, // Default: null
 *                 id?: scalar|null,
 *                 pool?: scalar|null,
 *             },
 *             entity_listeners?: array{
 *                 entities?: array<string, array{ // Default: []
 *                     listeners?: array<string, array{ // Default: []
 *                         events?: list<array{ // Default: []
 *                             type?: scalar|null,
 *                             method?: scalar|null, // Default: null
 *                         }>,
 *                     }>,
 *                 }>,
 *             },
 *             connection?: scalar|null,
 *             class_metadata_factory_name?: scalar|null, // Default: "Doctrine\\ORM\\Mapping\\ClassMetadataFactory"
 *             default_repository_class?: scalar|null, // Default: "Doctrine\\ORM\\EntityRepository"
 *             auto_mapping?: scalar|null, // Default: false
 *             naming_strategy?: scalar|null, // Default: "doctrine.orm.naming_strategy.default"
 *             quote_strategy?: scalar|null, // Default: "doctrine.orm.quote_strategy.default"
 *             typed_field_mapper?: scalar|null, // Default: "doctrine.orm.typed_field_mapper.default"
 *             entity_listener_resolver?: scalar|null, // Default: null
 *             fetch_mode_subselect_batch_size?: scalar|null,
 *             repository_factory?: scalar|null, // Default: "doctrine.orm.container_repository_factory"
 *             schema_ignore_classes?: list<scalar|null>,
 *             report_fields_where_declared?: bool, // Set to "true" to opt-in to the new mapping driver mode that was added in Doctrine ORM 2.16 and will be mandatory in ORM 3.0. See https://github.com/doctrine/orm/pull/10455. // Default: true
 *             validate_xml_mapping?: bool, // Set to "true" to opt-in to the new mapping driver mode that was added in Doctrine ORM 2.14. See https://github.com/doctrine/orm/pull/6728. // Default: false
 *             second_level_cache?: array{
 *                 region_cache_driver?: string|array{
 *                     type?: scalar|null, // Default: null
 *                     id?: scalar|null,
 *                     pool?: scalar|null,
 *                 },
 *                 region_lock_lifetime?: scalar|null, // Default: 60
 *                 log_enabled?: bool, // Default: true
 *                 region_lifetime?: scalar|null, // Default: 3600
 *                 enabled?: bool, // Default: true
 *                 factory?: scalar|null,
 *                 regions?: array<string, array{ // Default: []
 *                     cache_driver?: string|array{
 *                         type?: scalar|null, // Default: null
 *                         id?: scalar|null,
 *                         pool?: scalar|null,
 *                     },
 *                     lock_path?: scalar|null, // Default: "%kernel.cache_dir%/doctrine/orm/slc/filelock"
 *                     lock_lifetime?: scalar|null, // Default: 60
 *                     type?: scalar|null, // Default: "default"
 *                     lifetime?: scalar|null, // Default: 0
 *                     service?: scalar|null,
 *                     name?: scalar|null,
 *                 }>,
 *                 loggers?: array<string, array{ // Default: []
 *                     name?: scalar|null,
 *                     service?: scalar|null,
 *                 }>,
 *             },
 *             hydrators?: array<string, scalar|null>,
 *             mappings?: array<string, bool|string|array{ // Default: []
 *                 mapping?: scalar|null, // Default: true
 *                 type?: scalar|null,
 *                 dir?: scalar|null,
 *                 alias?: scalar|null,
 *                 prefix?: scalar|null,
 *                 is_bundle?: bool,
 *             }>,
 *             dql?: array{
 *                 string_functions?: array<string, scalar|null>,
 *                 numeric_functions?: array<string, scalar|null>,
 *                 datetime_functions?: array<string, scalar|null>,
 *             },
 *             filters?: array<string, string|array{ // Default: []
 *                 class: scalar|null,
 *                 enabled?: bool, // Default: false
 *                 parameters?: array<string, mixed>,
 *             }>,
 *             identity_generation_preferences?: array<string, scalar|null>,
 *         }>,
 *         resolve_target_entities?: array<string, scalar|null>,
 *     },
 * }
 * @psalm-type DoctrineMigrationsConfig = array{
 *     migrations_paths?: array<string, scalar|null>,
 *     services?: array<string, scalar|null>,
 *     factories?: array<string, scalar|null>,
 *     storage?: array{ // Storage to use for migration status metadata.
 *         table_storage?: array{ // The default metadata storage, implemented as a table in the database.
 *             table_name?: scalar|null, // Default: null
 *             version_column_name?: scalar|null, // Default: null
 *             version_column_length?: scalar|null, // Default: null
 *             executed_at_column_name?: scalar|null, // Default: null
 *             execution_time_column_name?: scalar|null, // Default: null
 *         },
 *     },
 *     migrations?: list<scalar|null>,
 *     connection?: scalar|null, // Connection name to use for the migrations database. // Default: null
 *     em?: scalar|null, // Entity manager name to use for the migrations database (available when doctrine/orm is installed). // Default: null
 *     all_or_nothing?: scalar|null, // Run all migrations in a transaction. // Default: false
 *     check_database_platform?: scalar|null, // Adds an extra check in the generated migrations to allow execution only on the same platform as they were initially generated on. // Default: true
 *     custom_template?: scalar|null, // Custom template path for generated migration classes. // Default: null
 *     organize_migrations?: scalar|null, // Organize migrations mode. Possible values are: "BY_YEAR", "BY_YEAR_AND_MONTH", false // Default: false
 *     enable_profiler?: bool, // Whether or not to enable the profiler collector to calculate and visualize migration status. This adds some queries overhead. // Default: false
 *     transactional?: bool, // Whether or not to wrap migrations in a single transaction. // Default: true
 * }
 * @psalm-type CmfRoutingConfig = array{
 *     chain?: array{
 *         routers_by_id?: array<string, scalar|null>,
 *         replace_symfony_router?: bool, // Default: true
 *     },
 *     dynamic?: bool|array{
 *         enabled?: bool, // Default: false
 *         route_collection_limit?: scalar|null, // Default: 0
 *         generic_controller?: scalar|null, // Default: null
 *         default_controller?: scalar|null, // Default: null
 *         controllers_by_type?: array<string, scalar|null>,
 *         controllers_by_class?: array<string, scalar|null>,
 *         templates_by_class?: array<string, scalar|null>,
 *         persistence?: array{
 *             phpcr?: bool|array{
 *                 enabled?: bool, // Default: false
 *                 manager_name?: scalar|null, // Default: null
 *                 route_basepaths?: list<scalar|null>,
 *                 enable_initializer?: bool, // Default: true
 *             },
 *             orm?: bool|array{
 *                 enabled?: bool, // Default: false
 *                 manager_name?: scalar|null, // Default: null
 *                 route_class?: scalar|null, // Default: "Symfony\\Cmf\\Bundle\\RoutingBundle\\Doctrine\\Orm\\Route"
 *             },
 *         },
 *         uri_filter_regexp?: scalar|null, // Default: ""
 *         route_provider_service_id?: scalar|null,
 *         route_filters_by_id?: array<string, scalar|null>,
 *         content_repository_service_id?: scalar|null,
 *         locales?: list<scalar|null>,
 *         limit_candidates?: int, // Default: 20
 *         match_implicit_locale?: bool, // Default: true
 *         redirectable_url_matcher?: bool, // Default: false
 *         auto_locale_pattern?: bool, // Default: false
 *         url_generator?: scalar|null, // URL generator service ID // Default: "cmf_routing.generator"
 *     },
 * }
 * @psalm-type SchebTwoFactorConfig = array{
 *     persister?: scalar|null, // Default: "scheb_two_factor.persister.doctrine"
 *     model_manager_name?: scalar|null, // Default: null
 *     security_tokens?: list<scalar|null>,
 *     ip_whitelist?: list<scalar|null>,
 *     ip_whitelist_provider?: scalar|null, // Default: "scheb_two_factor.default_ip_whitelist_provider"
 *     two_factor_token_factory?: scalar|null, // Default: "scheb_two_factor.default_token_factory"
 *     two_factor_provider_decider?: scalar|null, // Default: "scheb_two_factor.default_provider_decider"
 *     two_factor_condition?: scalar|null, // Default: null
 *     code_reuse_cache?: scalar|null, // Default: null
 *     code_reuse_cache_duration?: int, // Default: 60
 *     code_reuse_default_handler?: scalar|null, // Default: null
 *     google?: bool|array{
 *         enabled?: scalar|null, // Default: false
 *         form_renderer?: scalar|null, // Default: null
 *         issuer?: scalar|null, // Default: null
 *         server_name?: scalar|null, // Default: null
 *         template?: scalar|null, // Default: "@SchebTwoFactor/Authentication/form.html.twig"
 *         digits?: int, // Default: 6
 *         leeway?: int, // Default: 0
 *     },
 * }
 * @psalm-type FosJsRoutingConfig = array{
 *     serializer?: scalar|null,
 *     routes_to_expose?: list<scalar|null>,
 *     router?: scalar|null, // Default: "router"
 *     request_context_base_url?: scalar|null, // Default: null
 *     cache_control?: array{
 *         public?: bool, // Default: false
 *         expires?: scalar|null, // Default: null
 *         maxage?: scalar|null, // Default: null
 *         smaxage?: scalar|null, // Default: null
 *         vary?: list<scalar|null>,
 *     },
 * }
 * @psalm-type FlysystemConfig = array{
 *     storages?: array<string, array{ // Default: []
 *         adapter: scalar|null,
 *         options?: list<mixed>,
 *         visibility?: scalar|null, // Default: null
 *         directory_visibility?: scalar|null, // Default: null
 *         retain_visibility?: bool|null, // Default: null
 *         case_sensitive?: bool, // Default: true
 *         disable_asserts?: bool, // Default: false
 *         public_url?: list<scalar|null>,
 *         path_normalizer?: scalar|null, // Default: null
 *         public_url_generator?: scalar|null, // Default: null
 *         temporary_url_generator?: scalar|null, // Default: null
 *         read_only?: bool, // Default: false
 *     }>,
 * }
 * @psalm-type KnpPaginatorConfig = array{
 *     default_options?: array{
 *         sort_field_name?: scalar|null, // Default: "sort"
 *         sort_direction_name?: scalar|null, // Default: "direction"
 *         filter_field_name?: scalar|null, // Default: "filterField"
 *         filter_value_name?: scalar|null, // Default: "filterValue"
 *         page_name?: scalar|null, // Default: "page"
 *         distinct?: bool, // Default: true
 *         page_out_of_range?: scalar|null, // Default: "ignore"
 *         default_limit?: scalar|null, // Default: 10
 *     },
 *     template?: array{
 *         pagination?: scalar|null, // Default: "@KnpPaginator/Pagination/sliding.html.twig"
 *         rel_links?: scalar|null, // Default: "@KnpPaginator/Pagination/rel_links.html.twig"
 *         filtration?: scalar|null, // Default: "@KnpPaginator/Pagination/filtration.html.twig"
 *         sortable?: scalar|null, // Default: "@KnpPaginator/Pagination/sortable_link.html.twig"
 *     },
 *     page_range?: scalar|null, // Default: 5
 *     page_limit?: scalar|null, // Default: null
 *     convert_exception?: bool, // Default: false
 *     remove_first_page_param?: bool, // Default: false
 * }
 * @psalm-type DebugConfig = array{
 *     max_items?: int, // Max number of displayed items past the first level, -1 means no limit. // Default: 2500
 *     min_depth?: int, // Minimum tree depth to clone all the items, 1 is default. // Default: 1
 *     max_string_length?: int, // Max length of displayed strings, -1 means no limit. // Default: -1
 *     dump_destination?: scalar|null, // A stream URL where dumps should be written to. // Default: null
 *     theme?: "dark"|"light", // Changes the color of the dump() output when rendered directly on the templating. "dark" (default) or "light". // Default: "dark"
 * }
 * @psalm-type WebProfilerConfig = array{
 *     toolbar?: bool|array{ // Profiler toolbar configuration
 *         enabled?: bool, // Default: false
 *         ajax_replace?: bool, // Replace toolbar on AJAX requests // Default: false
 *     },
 *     intercept_redirects?: bool, // Default: false
 *     excluded_ajax_paths?: scalar|null, // Default: "^/((index|app(_[\\w]+)?)\\.php/)?_wdt"
 * }
 * @psalm-type PimcoreAdminConfig = array{
 *     gdpr_data_extractor?: array{
 *         dataObjects?: array{ // Settings for DataObjects DataProvider
 *             classes?: list<array{ // MY_CLASS_NAME: include: true allowDelete: false includedRelations: - manualSegemens - calculatedSegments // Default: []
 *                 include?: bool, // Set if class should be considered in export. // Default: true
 *                 allowDelete?: bool, // Allow delete of objects directly in preview grid. // Default: false
 *                 includedRelations?: list<scalar|null>,
 *             }>,
 *         },
 *         assets?: array{ // Settings for Assets DataProvider
 *             types?: list<array{ // asset types // Default: []
 *             }>,
 *         },
 *     },
 *     objects?: array{
 *         notes_events?: array{
 *             types?: list<scalar|null>,
 *         },
 *     },
 *     assets?: array{
 *         notes_events?: array{
 *             types?: list<scalar|null>,
 *         },
 *         hide_edit_image?: bool, // Default: false
 *         disable_tree_preview?: bool, // Default: true
 *     },
 *     documents?: array{
 *         notes_events?: array{
 *             types?: list<scalar|null>,
 *         },
 *         email_search?: list<scalar|null>,
 *     },
 *     notifications?: bool|array{
 *         enabled?: bool, // Default: true
 *         check_new_notification?: bool|array{ // Can be used to enable or disable the check of new notifications (url: /admin/notification/find-last-unread).
 *             enabled?: bool, // Default: true
 *             interval?: int, // Interval in seconds to check new notifications // Default: 30
 *         },
 *     },
 *     user?: array{
 *         default_key_bindings?: list<array{ // Default: []
 *             key: scalar|null,
 *             action: scalar|null,
 *             alt?: scalar|null, // Default: false
 *             ctrl?: scalar|null, // Default: false
 *             shift?: scalar|null, // Default: false
 *         }>,
 *     },
 *     admin_languages?: list<scalar|null>,
 *     csrf_protection?: array{
 *         excluded_routes?: list<scalar|null>,
 *     },
 *     admin_csp_header?: bool|array{ // Can be used to enable or disable the Content Security Policy headers.
 *         enabled?: bool, // Default: true
 *         exclude_paths?: list<scalar|null>,
 *         additional_urls?: array{
 *             default-src?: list<scalar|null>,
 *             img-src?: list<scalar|null>,
 *             script-src?: list<scalar|null>,
 *             style-src?: list<scalar|null>,
 *             connect-src?: list<scalar|null>,
 *             font-src?: list<scalar|null>,
 *             media-src?: list<scalar|null>,
 *             frame-src?: list<scalar|null>,
 *         },
 *     },
 *     custom_admin_path_identifier?: scalar|null, // Default: null
 *     custom_admin_route_name?: scalar|null, // Default: "my_custom_admin_entry_point"
 *     branding?: array{
 *         login_screen_invert_colors?: bool, // Default: false
 *         color_login_screen?: scalar|null, // Default: null
 *         color_admin_interface?: scalar|null, // Default: null
 *         color_admin_interface_background?: scalar|null, // Default: null
 *         login_screen_custom_image?: scalar|null, // Default: ""
 *     },
 *     session?: array{
 *         attribute_bags?: array<string, array{ // Default: []
 *             storage_key?: scalar|null, // Default: null
 *         }>,
 *     },
 *     translations?: array{
 *         path?: scalar|null, // Default: null
 *     },
 *     security_firewall?: mixed,
 *     config_location?: array{
 *         admin_system_settings?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *             read_target?: array{
 *                 type?: "symfony-config"|"settings-store", // Default: null
 *                 options?: list<mixed>,
 *             },
 *         },
 *     },
 * }
 * @psalm-type PimcoreDataHubConfig = array{
 *     graphql?: array{
 *         not_allowed_policy?: scalar|null, // throw exception = 1, return null = 2 // Default: 2
 *         output_cache_enabled?: bool, // enables output cache for graphql responses. It is disabled by default // Default: false
 *         output_cache_lifetime?: int, // output cache in seconds. Default is 30 seconds // Default: 30
 *         allow_introspection?: bool, // enables introspection for graphql. It is enabled by default // Default: true
 *     },
 *     configurations?: list<mixed>,
 *     supported_types?: list<mixed>,
 *     config_location?: array{
 *         data_hub?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *     },
 * }
 * @psalm-type WebpackEncoreConfig = array{
 *     output_path: scalar|null, // The path where Encore is building the assets - i.e. Encore.setOutputPath()
 *     crossorigin?: false|"anonymous"|"use-credentials", // crossorigin value when Encore.enableIntegrityHashes() is used, can be false (default), anonymous or use-credentials // Default: false
 *     preload?: bool, // preload all rendered script and link tags automatically via the http2 Link header. // Default: false
 *     cache?: bool, // Enable caching of the entry point file(s) // Default: false
 *     strict_mode?: bool, // Throw an exception if the entrypoints.json file is missing or an entry is missing from the data // Default: true
 *     builds?: array<string, scalar|null>,
 *     script_attributes?: array<string, scalar|null>,
 *     link_attributes?: array<string, scalar|null>,
 * }
 * @psalm-type PimcoreCustomReportsConfig = array{
 *     definitions?: list<array{ // Default: []
 *         id?: scalar|null,
 *         name?: scalar|null,
 *         niceName?: scalar|null,
 *         sql?: scalar|null,
 *         group?: scalar|null,
 *         groupIconClass?: scalar|null,
 *         iconClass?: scalar|null,
 *         menuShortcut?: bool,
 *         reportClass?: scalar|null,
 *         chartType?: scalar|null,
 *         pieColumn?: scalar|null,
 *         pieLabelColumn?: scalar|null,
 *         xAxis?: mixed,
 *         yAxis?: mixed,
 *         modificationDate?: int,
 *         creationDate?: int,
 *         shareGlobally?: bool,
 *         sharedUserNames?: mixed,
 *         sharedRoleNames?: mixed,
 *         dataSourceConfig?: list<mixed>,
 *         columnConfiguration?: list<mixed>,
 *         pagination?: bool,
 *     }>,
 *     adapters?: array<string, scalar|null>,
 *     config_location?: array{
 *         custom_reports?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *     },
 * }
 * @psalm-type PimcoreGlossaryConfig = array{
 *     blocked_tags?: array<string, scalar|null>,
 * }
 * @psalm-type PimcoreSeoConfig = array{
 *     sitemaps?: array{
 *         generators?: array<string, bool|string|array{ // Default: []
 *             enabled?: bool, // Default: true
 *             generator_id?: scalar|null,
 *             priority?: int, // Default: 0
 *         }>,
 *     },
 *     redirects?: array{
 *         status_codes?: list<scalar|null>,
 *         auto_create_redirects?: bool, // Auto create redirects on moving documents & changing pretty url, updating Url slugs in Data Objects. // Default: false
 *     },
 * }
 * @psalm-type PrestaSitemapConfig = array{
 *     generator?: scalar|null, // Default: "presta_sitemap.generator_default"
 *     dumper?: scalar|null, // Default: "presta_sitemap.dumper_default"
 *     timetolive?: int, // Default: 3600
 *     sitemap_file_prefix?: scalar|null, // Sets sitemap filename prefix defaults to "sitemap" -> sitemap.xml (for index); sitemap.<section>.xml(.gz) (for sitemaps) // Default: "sitemap"
 *     items_by_set?: int, // The maximum number of items allowed in single sitemap. // Default: 50000
 *     route_annotation_listener?: scalar|null, // Default: true
 *     dump_directory?: scalar|null, // The directory to which the sitemap will be dumped. It can be either absolute, or relative (to the place where the command will be triggered). Default to Symfony's public dir. // Default: "%kernel.project_dir%/public"
 *     defaults?: array{
 *         priority?: scalar|null, // Default: 0.5
 *         changefreq?: scalar|null, // Default: "daily"
 *         lastmod?: scalar|null, // Default: "now"
 *     },
 *     default_section?: scalar|null, // The default section in which static routes are registered. // Default: "default"
 *     alternate?: bool|array{ // Automatically generate alternate (hreflang) urls with static routes. Requires route_annotation_listener config to be enabled.
 *         enabled?: bool, // Default: false
 *         default_locale?: scalar|null, // The default locale of your routes. // Default: "en"
 *         locales?: list<scalar|null>,
 *         i18n?: "symfony"|"jms", // Strategy used to create your i18n routes. // Default: "symfony"
 *     },
 * }
 * @psalm-type PimcoreStaticRoutesConfig = array{
 *     definitions?: list<array{ // Default: []
 *         name?: scalar|null,
 *         pattern?: scalar|null,
 *         reverse?: scalar|null,
 *         controller?: scalar|null,
 *         variables?: scalar|null,
 *         defaults?: scalar|null,
 *         siteId?: list<int>,
 *         methods?: list<scalar|null>,
 *         priority?: int,
 *         creationDate?: int,
 *         modificationDate?: int,
 *     }>,
 *     config_location?: array{
 *         staticroutes?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *     },
 * }
 * @psalm-type PimcoreUuidConfig = array{
 *     instance_identifier?: scalar|null, // UUID instance identifier. Has to be unique throughout multiple Pimcore instances. UUID generation will be automatically enabled if a Instance identifier is provided (do not change the instance identifier afterwards - this will cause invalid UUIDs) // Default: null
 * }
 * @psalm-type PimcoreXliffConfig = array{
 *     data_object?: array{
 *         translation_extractor?: array{
 *             attributes?: list<list<scalar|null>>,
 *         },
 *     },
 * }
 * @psalm-type PimcoreDataImporterConfig = array{
 *     messenger_queue_processing?: array{ // Configure import queue processing via symfony messenger
 *         activated?: bool, // Activate dispatching messages after import was prepared. Will start import as soon as messages are processed via symfony messenger. // Default: false
 *         worker_count_lifetime?: int, // Lifetime of tmp store entry for current worker count entry. After lifetime, the value will be cleared. Default to 30 minutes. // Default: 1800
 *         worker_count_parallel?: int, // Count of maximum parallel worker messages for parallel imports. // Default: 3
 *         worker_item_count?: int, // Count of items imported per worker message. // Default: 200
 *     },
 * }
 * @psalm-type PimcorePerspectiveEditorConfig = array<mixed>
 * @psalm-type FolderCreatorConfig = array<mixed>
 * @psalm-type RoleCreatorConfig = array<mixed>
 * @psalm-type CoreShopMessengerConfig = array{
 *     pimcore_admin?: array{
 *         js?: array<string, scalar|null>,
 *         css?: array<string, scalar|null>,
 *         editmode_js?: array<string, scalar|null>,
 *         editmode_css?: array<string, scalar|null>,
 *         permissions?: scalar|null, // Default: ["messenger"]
 *     },
 *     doctrine?: array{
 *         table_name?: scalar|null, // Default: null
 *         connection?: scalar|null, // Default: null
 *     },
 * }
 * @psalm-type KnpMenuConfig = array{
 *     providers?: array{
 *         builder_alias?: bool, // Default: true
 *     },
 *     twig?: array{
 *         template?: scalar|null, // Default: "@KnpMenu/menu.html.twig"
 *     },
 *     templating?: bool, // Default: false
 *     default_renderer?: scalar|null, // Default: "twig"
 * }
 * @psalm-type ObjectLayoutGridConfig = array<mixed>
 * @psalm-type PimcoreConfig = array{
 *     bundles?: array{ // Define parameters for Pimcore Bundle Locator
 *         search_paths?: list<scalar|null>,
 *         handle_composer?: bool, // Define whether it should be scanning bundles through composer /vendor folder or not // Default: true
 *     },
 *     flags?: list<scalar|null>,
 *     translations?: array{
 *         domains?: list<scalar|null>,
 *         admin_translation_mapping?: array<string, scalar|null>,
 *         debugging?: bool|array{ // If debugging is enabled, the translator will return the plain translation key instead of the translated message.
 *             enabled?: bool, // Default: true
 *             parameter?: scalar|null, // Default: "pimcore_debug_translations"
 *         },
 *     },
 *     maps?: array{
 *         tile_layer_url_template?: scalar|null, // Default: "https://a.tile.openstreetmap.org/{z}/{x}/{y}.png"
 *         geocoding_url_template?: scalar|null, // Default: "https://nominatim.openstreetmap.org/search?q={q}&addressdetails=1&format=json&limit=1"
 *         reverse_geocoding_url_template?: scalar|null, // Default: "https://nominatim.openstreetmap.org/reverse?format=json&lat={lat}&lon={lon}&addressdetails=1"
 *     },
 *     general?: array{
 *         timezone?: scalar|null, // Default: ""
 *         path_variable?: scalar|null, // Additional $PATH variable (: separated) (/x/y:/foo/bar): // Default: null
 *         domain?: scalar|null, // Default: ""
 *         redirect_to_maindomain?: bool, // Default: false
 *         language?: scalar|null, // Deprecated: The child node "language" at path "pimcore.general.language" is deprecated. // Default: "en"
 *         valid_languages?: list<scalar|null>,
 *         required_languages?: list<scalar|null>,
 *         fallback_languages?: list<scalar|null>,
 *         default_language?: scalar|null, // Default: "en"
 *         disable_usage_statistics?: bool, // Default: false
 *         debug_admin_translations?: bool, // Debug Admin-Translations (text in UI will be displayed wrapped in +) // Default: false
 *     },
 *     maintenance?: array{
 *         housekeeping?: array{
 *             cleanup_tmp_files_atime_older_than?: int, // Integer value in seconds. // Default: 86400
 *             cleanup_profiler_files_atime_older_than?: int, // Integer value in seconds. // Default: 1800
 *         },
 *     },
 *     objects?: array{
 *         ignore_localized_query_fallback?: bool, // Default: false
 *         tree_paging_limit?: int, // Default: 30
 *         auto_save_interval?: int, // Default: 60
 *         versions?: array{
 *             days?: scalar|null, // Default: null
 *             steps?: scalar|null, // Default: null
 *             disable_events?: bool, // Default: false
 *             disable_stack_trace?: bool, // Default: false
 *         },
 *         custom_layouts?: array{
 *             definitions?: list<array{ // Default: []
 *                 id?: scalar|null,
 *                 name?: scalar|null,
 *                 description?: scalar|null, // Default: null
 *                 creationDate?: int,
 *                 modificationDate?: int,
 *                 userOwner?: int,
 *                 userModification?: int,
 *                 classId?: scalar|null,
 *                 default?: int,
 *                 layoutDefinitions?: mixed,
 *             }>,
 *         },
 *         select_options?: array{
 *             definitions?: list<array{ // Default: []
 *                 id?: scalar|null,
 *                 group?: scalar|null,
 *                 adminOnly?: bool, // Default: false
 *                 useTraits?: scalar|null,
 *                 implementsInterfaces?: scalar|null,
 *                 selectOptions?: list<array{ // Default: []
 *                     value?: scalar|null,
 *                     label?: scalar|null,
 *                     name?: scalar|null,
 *                 }>,
 *             }>,
 *         },
 *         class_definitions?: array{
 *             data?: array{
 *                 map?: array<string, scalar|null>,
 *                 prefixes?: list<scalar|null>,
 *             },
 *             layout?: array{
 *                 map?: array<string, scalar|null>,
 *                 prefixes?: list<scalar|null>,
 *             },
 *         },
 *         ...<mixed>
 *     },
 *     assets?: array{
 *         thumbnails?: array{
 *             allowed_formats?: list<scalar|null>,
 *             max_scaling_factor?: float, // Default: 5.0
 *         },
 *         frontend_prefixes?: array{
 *             source?: scalar|null, // Default: ""
 *             thumbnail?: scalar|null, // Default: ""
 *             thumbnail_deferred?: scalar|null, // Default: ""
 *         },
 *         preview_image_thumbnail?: scalar|null, // Default: null
 *         default_upload_path?: scalar|null, // Default: "_default_upload_bucket"
 *         tree_paging_limit?: int, // Default: 100
 *         image?: array{
 *             max_pixels?: int, // Maximum number of pixels an image can have when added (width × height). // Default: 40000000
 *             low_quality_image_preview?: bool|array{ // Allow a LQIP SVG image to be generated alongside any other thumbnails.
 *                 enabled?: bool, // Default: true
 *             },
 *             thumbnails?: array{
 *                 definitions?: list<array{ // Default: []
 *                     id?: scalar|null,
 *                     name?: scalar|null,
 *                     description?: scalar|null,
 *                     group?: scalar|null,
 *                     format?: scalar|null,
 *                     quality?: scalar|null,
 *                     highResolution?: scalar|null,
 *                     preserveColor?: bool,
 *                     preserveMetaData?: bool,
 *                     rasterizeSVG?: bool,
 *                     useCropBox?: bool,
 *                     downloadable?: bool,
 *                     forceProcessICCProfiles?: bool,
 *                     modificationDate?: int,
 *                     creationDate?: int,
 *                     preserveAnimation?: bool,
 *                     items?: list<array{ // Default: []
 *                         method?: scalar|null,
 *                         arguments?: list<mixed>,
 *                     }>,
 *                     medias?: list<list<array{ // Default: []
 *                             method?: scalar|null,
 *                             arguments?: list<mixed>,
 *                         }>>,
 *                 }>,
 *                 clip_auto_support?: bool, // Try to detect and use clipping paths and masks in images when generating thumbnails. // Default: true
 *                 max_srcset_dpi_factor?: int, // Maximum generated srcset DPI factor for web images. // Default: 2
 *                 image_optimizers?: bool|array{
 *                     enabled?: bool, // Default: true
 *                 },
 *                 auto_formats?: list<bool|array{ // Default: {"avif":{"enabled":true,"quality":50},"webp":{"enabled":true,"quality":null}}
 *                     enabled?: bool, // Default: true
 *                     quality?: scalar|null,
 *                 }>,
 *                 status_cache?: bool, // Store image metadata such as filename and modification date in assets_image_thumbnail_cache, this is helpful when using remote object storage for thumbnails. // Default: true
 *                 auto_clear_temp_files?: bool, // Automatically delete all image thumbnail files any time an image or its metadata is updated. // Default: true
 *             },
 *         },
 *         video?: array{
 *             thumbnails?: array{
 *                 definitions?: list<array{ // Default: []
 *                     id?: scalar|null,
 *                     name?: scalar|null,
 *                     description?: scalar|null,
 *                     group?: scalar|null,
 *                     videoBitrate?: scalar|null,
 *                     audioBitrate?: scalar|null,
 *                     quality?: scalar|null,
 *                     modificationDate?: int,
 *                     creationDate?: int,
 *                     items?: list<array{ // Default: []
 *                         method?: scalar|null,
 *                         arguments?: list<mixed>,
 *                     }>,
 *                     medias?: list<list<array{ // Default: []
 *                             method?: scalar|null,
 *                             arguments?: list<mixed>,
 *                         }>>,
 *                 }>,
 *                 auto_clear_temp_files?: bool, // Automatically delete all video thumbnail files any time an image or its metadata is updated. // Default: true
 *             },
 *         },
 *         document?: array{
 *             thumbnails?: array{
 *                 enabled?: bool, // Process thumbnails for Asset documents. // Default: true
 *             },
 *             process_page_count?: bool, // Process & store page count for Asset documents. Internally required for thumbnails & text generation // Default: true
 *             process_text?: bool, // Process text for Asset documents (e.g. used by backend search). // Default: true
 *             scan_pdf?: bool, // Scan PDF documents for unsafe JavaScript. // Default: true
 *             open_pdf_in_new_tab?: "all-pdfs"|"only-unsafe"|"none", // Default: "only-unsafe"
 *         },
 *         versions?: array{
 *             days?: scalar|null, // Default: null
 *             steps?: scalar|null, // Default: null
 *             disable_events?: bool, // Default: false
 *             use_hardlinks?: bool, // Default: true
 *             disable_stack_trace?: bool, // Default: false
 *         },
 *         icc_rgb_profile?: scalar|null, // Absolute path to default ICC RGB profile (if no embedded profile is given) // Default: null
 *         icc_cmyk_profile?: scalar|null, // Absolute path to default ICC CMYK profile (if no embedded profile is given) // Default: null
 *         metadata?: array{
 *             alt?: scalar|null, // Set to replace the default metadata used for auto alt functionality in frontend // Default: ""
 *             copyright?: scalar|null, // Set to replace the default metadata used for copyright in frontend // Default: ""
 *             title?: scalar|null, // Set to replace the default metadata used for title in frontend // Default: ""
 *             predefined?: array{
 *                 definitions?: list<array{ // Default: []
 *                     name?: scalar|null,
 *                     description?: scalar|null,
 *                     group?: scalar|null,
 *                     language?: scalar|null,
 *                     type?: scalar|null,
 *                     data?: scalar|null,
 *                     targetSubtype?: scalar|null,
 *                     config?: scalar|null,
 *                     inheritable?: bool,
 *                     creationDate?: int,
 *                     modificationDate?: int,
 *                 }>,
 *             },
 *             class_definitions?: array{
 *                 data?: array{
 *                     map?: array<string, scalar|null>,
 *                     prefixes?: list<scalar|null>,
 *                 },
 *             },
 *         },
 *         type_definitions?: array{
 *             map?: list<array{ // Default: []
 *                 class?: scalar|null,
 *                 matching?: list<scalar|null>,
 *             }>,
 *         },
 *     },
 *     documents?: array{
 *         doc_types?: array{
 *             definitions?: list<array{ // Default: []
 *                 name?: scalar|null,
 *                 group?: scalar|null,
 *                 module?: scalar|null,
 *                 controller?: scalar|null,
 *                 template?: scalar|null,
 *                 type?: scalar|null,
 *                 priority?: int,
 *                 creationDate?: int,
 *                 modificationDate?: int,
 *                 staticGeneratorEnabled?: bool, // Default: false
 *             }>,
 *         },
 *         versions?: array{
 *             days?: scalar|null, // Default: null
 *             steps?: scalar|null, // Default: null
 *             disable_events?: bool, // Default: false
 *             disable_stack_trace?: bool, // Default: false
 *         },
 *         default_controller?: scalar|null, // Default: "App\\Controller\\DefaultController::defaultAction"
 *         error_pages?: array{
 *             default?: scalar|null, // Default: null
 *             localized?: list<scalar|null>,
 *         },
 *         allow_trailing_slash?: scalar|null, // Default: "no"
 *         generate_preview?: bool, // Default: false
 *         preview_url_prefix?: scalar|null, // Default: ""
 *         tree_paging_limit?: int, // Default: 50
 *         editables?: array{
 *             map?: array<string, scalar|null>,
 *             prefixes?: list<scalar|null>,
 *         },
 *         areas?: array{
 *             autoload?: bool, // Default: true
 *         },
 *         auto_save_interval?: int, // Default: 60
 *         static_page_router?: array{
 *             enabled?: bool, // Enable Static Page router for document when using remote storage for generated pages // Default: false
 *             route_pattern?: scalar|null, // Optionally define route patterns to lookup static pages. Regular Expressions like: /^\/en\/Magazine/ // Default: null
 *         },
 *         static_page_generator?: array{
 *             use_main_domain?: bool, // Use main domain for static pages folder in tmp/pages // Default: false
 *             headers?: list<array{ // Default: []
 *                 name?: scalar|null,
 *                 value?: scalar|null,
 *             }>,
 *         },
 *         type_definitions?: array{
 *             map?: list<array{ // Default: []
 *                 class?: scalar|null,
 *                 translatable?: bool, // Default: true
 *                 valid_table?: scalar|null, // Default: null
 *                 direct_route?: bool, // Default: false
 *                 translatable_inheritance?: bool, // Default: true
 *                 children_supported?: bool, // Default: true
 *                 only_printable_childrens?: bool, // Default: false
 *                 predefined_document_types?: bool, // Default: false
 *             }>,
 *         },
 *         ...<mixed>
 *     },
 *     encryption?: array{
 *         secret?: scalar|null, // Default: null
 *     },
 *     models?: array{
 *         class_overrides?: array<string, scalar|null>,
 *     },
 *     routing?: array{
 *         static?: array{
 *             locale_params?: list<scalar|null>,
 *         },
 *     },
 *     full_page_cache?: bool|array{
 *         enabled?: bool, // Default: true
 *         lifetime?: scalar|null, // Optional output-cache lifetime (in seconds) after the cache expires, if not defined the cache will be cleaned on every action inside the CMS, otherwise not (for high traffic sites) // Default: null
 *         exclude_patterns?: scalar|null, // Regular Expressions like: /^\/dir\/toexclude/
 *         exclude_cookie?: scalar|null, // Comma separated list of cookie names, that will automatically disable the full-page cache
 *         ...<mixed>
 *     },
 *     context?: array<string, array{ // Default: []
 *         routes?: list<null|array{ // Default: []
 *             path?: scalar|null, // Default: false
 *             route?: scalar|null, // Default: false
 *             host?: scalar|null, // Default: false
 *             methods?: list<scalar|null>,
 *         }>,
 *     }>,
 *     web_profiler?: array{
 *         toolbar?: array{
 *             excluded_routes?: list<null|array{ // Default: []
 *                 path?: scalar|null, // Default: false
 *                 route?: scalar|null, // Default: false
 *                 host?: scalar|null, // Default: false
 *                 methods?: list<scalar|null>,
 *             }>,
 *         },
 *     },
 *     security?: array{
 *         password?: array{
 *             algorithm?: "2y"|"argon2i"|"argon2id", // The hashing algorithm to use for backend users and objects containing a "password" field. // Default: "2y"
 *             options?: list<mixed>,
 *         },
 *         factory_type?: "encoder"|"password_hasher", // Default: "encoder"
 *         encoder_factories?: array<string, string|array{ // Default: []
 *             id?: scalar|null,
 *         }>,
 *         password_hasher_factories?: array<string, string|array{ // Default: []
 *             id?: scalar|null,
 *         }>,
 *     },
 *     email?: array{
 *         sender?: array{
 *             name?: scalar|null, // Default: ""
 *             email?: scalar|null, // Default: ""
 *         },
 *         return?: array{
 *             name?: scalar|null, // Default: ""
 *             email?: scalar|null, // Default: ""
 *         },
 *         debug?: array{
 *             email_addresses?: scalar|null, // Default: ""
 *         },
 *         usespecific?: scalar|null, // Default: false
 *     },
 *     workflows?: array<string, array{ // Default: []
 *         placeholders?: list<scalar|null>,
 *         custom_extensions?: array<mixed>,
 *         enabled?: bool, // Can be used to enable or disable the workflow. // Default: true
 *         priority?: int, // When multiple custom view or permission settings from different places in different workflows are valid, the workflow with the highest priority will be used. // Default: 0
 *         label?: scalar|null, // Will be used in the backend interface as nice name for the workflow. If not set the technical workflow name will be used as label too.
 *         audit_trail?: bool|array{ // Enable default audit trail feature provided by Symfony. Take a look at the Symfony docs for more details.
 *             enabled?: bool, // Default: false
 *         },
 *         type?: "workflow"|"state_machine", // A workflow with type "workflow" can handle multiple places at one time whereas a state_machine provides a finite state_machine (only one place at one time). Take a look at the Symfony docs for more details.
 *         marking_store?: array{ // Handles the way how the state/place is stored. If not defined "state_table" will be used as default. Take a look at @TODO for a description of the different types.
 *             type?: "multiple_state"|"single_state"|"state_table"|"data_object_multiple_state"|"data_object_splitted_state",
 *             arguments?: list<mixed>,
 *             service?: scalar|null,
 *         },
 *         supports?: list<scalar|null>,
 *         support_strategy?: array{ // Can be used to implement a special logic which subjects are supported by the workflow. For example only products matching certain criteria.
 *             type?: "expression", // Type "expression": a symfony expression to define a criteria.
 *             arguments?: list<mixed>,
 *             service?: scalar|null, // Define a custom service to handle the logic. Take a look at the Symfony docs for more details.
 *         },
 *         initial_markings?: list<scalar|null>,
 *         places?: list<array{ // Default: []
 *             label?: scalar|null, // Nice name which will be used in the Pimcore backend.
 *             title?: scalar|null, // Title/tooltip for this place when it is displayed in the header of the Pimcore element detail view in the backend. // Default: ""
 *             color?: scalar|null, // Color of the place which will be used in the Pimcore backend. // Default: "#bfdadc"
 *             colorInverted?: bool, // If set to true the color will be used as border and font color otherwise as background color. // Default: false
 *             visibleInHeader?: bool, // If set to false, the place will be hidden in the header of the Pimcore element detail view in the backend. // Default: true
 *             permissions?: list<array{ // Default: []
 *                 condition?: scalar|null, // A symfony expression can be configured here. The first set of permissions which are matching the condition will be used.
 *                 save?: bool, // save permission as it can be configured in Pimcore workplaces
 *                 publish?: bool, // publish permission as it can be configured in Pimcore workplaces
 *                 unpublish?: bool, // unpublish permission as it can be configured in Pimcore workplaces
 *                 delete?: bool, // delete permission as it can be configured in Pimcore workplaces
 *                 rename?: bool, // rename permission as it can be configured in Pimcore workplaces
 *                 view?: bool, // view permission as it can be configured in Pimcore workplaces
 *                 settings?: bool, // settings permission as it can be configured in Pimcore workplaces
 *                 versions?: bool, // versions permission as it can be configured in Pimcore workplaces
 *                 properties?: bool, // properties permission as it can be configured in Pimcore workplaces
 *                 modify?: bool, // a short hand for save, publish, unpublish, delete + rename
 *                 objectLayout?: scalar|null, // if set, the user will see the configured custom data object layout
 *             }>,
 *         }>,
 *         transitions: list<array{ // Default: []
 *             name: scalar|null,
 *             guard?: scalar|null, // An expression to block the transition
 *             from?: list<scalar|null>,
 *             to?: list<scalar|null>,
 *             options?: array{
 *                 label?: scalar|null, // Nice name for the Pimcore backend.
 *                 notes?: array{
 *                     commentEnabled?: bool, // If enabled a detail window will open when the user executes the transition. In this detail view the user be asked to enter a "comment". This comment then will be used as comment for the notes/events feature. // Default: false
 *                     commentRequired?: bool, // Set this to true if the comment should be a required field. // Default: false
 *                     commentSetterFn?: scalar|null, // Can be used for data objects. The comment will be saved to the data object additionally to the notes/events through this setter function.
 *                     commentGetterFn?: scalar|null, // Can be used for data objects to prefill the comment field with data from the data object.
 *                     type?: scalar|null, // Set's the type string in the saved note. // Default: "Status update"
 *                     title?: scalar|null, // An optional alternative "title" for the note, if blank the actions transition result is used.
 *                     additionalFields?: list<array{ // Default: []
 *                         name: scalar|null, // The technical name used in the input form.
 *                         fieldType: "input"|"numeric"|"textarea"|"select"|"datetime"|"date"|"user"|"checkbox", // The data component name/field type.
 *                         title?: scalar|null, // The label used by the field
 *                         required?: bool, // Whether or not the field is required. // Default: false
 *                         setterFn?: scalar|null, // Optional setter function (available in the element, for example in the updated object), if not specified, data will be added to notes. The Workflow manager will call the function with the whole field data.
 *                         fieldTypeSettings?: list<mixed>,
 *                     }>,
 *                     customHtml?: array{
 *                         position?: "top"|"center"|"bottom", // Set position of custom HTML inside modal (top, center, bottom). // Default: "top"
 *                         service?: scalar|null, // Define a custom service for rendering custom HTML within the note modal.
 *                     },
 *                 },
 *                 iconClass?: scalar|null, // CSS class to define the icon which will be used in the actions button in the backend.
 *                 objectLayout?: scalar|null, // Forces an object layout after the transition was performed. This objectLayout setting overrules all objectLayout settings within the places configs. // Default: false
 *                 notificationSettings?: list<array{ // Default: []
 *                     condition?: scalar|null, // A symfony expression can be configured here. All sets of notification which are matching the condition will be used.
 *                     notifyUsers?: list<scalar|null>,
 *                     notifyRoles?: list<scalar|null>,
 *                     channelType?: list<"mail"|"pimcore_notification">,
 *                     mailType?: "template"|"pimcore_document", // Type of mail source. // Default: "template"
 *                     mailPath?: scalar|null, // Path to mail source - either Symfony path to template or fullpath to Pimcore document. Optional use %_locale% as placeholder for language. // Default: "@PimcoreCore/Workflow/NotificationEmail/notificationEmail.html.twig"
 *                 }>,
 *                 changePublishedState?: "no_change"|"force_unpublished"|"force_published"|"save_version", // Change published state of element while transition (only available for documents and data objects). // Default: "no_change"
 *                 unsavedChangesBehaviour?: "save"|"warn"|"ignore", // Behaviour when workflow transition gets applied but there are unsaved changes // Default: "warn"
 *             },
 *         }>,
 *         globalActions?: list<array{ // Default: []
 *             label?: scalar|null, // Nice name for the Pimcore backend.
 *             iconClass?: scalar|null, // CSS class to define the icon which will be used in the actions button in the backend.
 *             objectLayout?: scalar|null, // Forces an object layout after the global action was performed. This objectLayout setting overrules all objectLayout settings within the places configs. // Default: false
 *             guard?: scalar|null, // An expression to block the action
 *             saveSubject?: bool, // Determines if the global action should perform a save on the subject, default behavior is set to true // Default: true
 *             to?: list<scalar|null>,
 *             notes?: array{ // See notes section of transitions. It works exactly the same way.
 *                 commentEnabled?: bool, // Default: false
 *                 commentRequired?: bool, // Default: false
 *                 commentSetterFn?: scalar|null,
 *                 commentGetterFn?: scalar|null,
 *                 type?: scalar|null, // Default: "Status update"
 *                 title?: scalar|null,
 *                 additionalFields?: list<array{ // Default: []
 *                     name: scalar|null,
 *                     fieldType: "input"|"textarea"|"select"|"datetime"|"date"|"user"|"checkbox",
 *                     title?: scalar|null,
 *                     required?: bool, // Default: false
 *                     setterFn?: scalar|null,
 *                     fieldTypeSettings?: list<mixed>,
 *                 }>,
 *                 customHtml?: array{
 *                     position?: "top"|"center"|"bottom", // Set position of custom HTML inside modal (top, center, bottom). // Default: "top"
 *                     service?: scalar|null, // Define a custom service for rendering custom HTML within the note modal.
 *                 },
 *             },
 *         }>,
 *     }>,
 *     httpclient?: array{
 *         adapter?: scalar|null, // Set to `Proxy` if proxy server should be used // Default: "Socket"
 *         proxy_host?: scalar|null, // Default: null
 *         proxy_port?: scalar|null, // Default: null
 *         proxy_user?: scalar|null, // Default: null
 *         proxy_pass?: scalar|null, // Default: null
 *     },
 *     applicationlog?: array{
 *         loggers?: array{
 *             db?: array{
 *                 min_level_or_list?: mixed, // Default: "debug"
 *                 max_level?: scalar|null, // Default: "emergency"
 *             },
 *         },
 *         mail_notification?: array{
 *             send_log_summary?: bool, // Send log summary via email // Default: false
 *             filter_priority?: scalar|null, // Filter threshold for email summary, choose one of: 8 (debug),7 (info),6 (notice),5 (warning),4 (error),3 (critical),2 (alert),1 (emerg). You can use the integer or the string representation. // Default: null
 *             mail_receiver?: scalar|null, // Log summary receivers. Separate multiple email receivers by using ;
 *         },
 *         archive_treshold?: scalar|null, // Archive threshold in days // Default: 30
 *         archive_alternative_database?: scalar|null, // Archive database name (optional). Tables will get archived to a different database, recommended when huge amounts of logs will be generated // Default: ""
 *         archive_db_table_storage_engine?: scalar|null, // DB storage engine to be used for archive tables (e.g. ARCHIVE, InnoDB, Aria, ...) // Default: "archive"
 *         delete_archive_threshold?: scalar|null, // Threshold for deleting application log archive tables (in months) // Default: "6"
 *     },
 *     properties?: array{
 *         predefined?: array{
 *             definitions?: list<array{ // Default: []
 *                 name?: scalar|null,
 *                 description?: scalar|null,
 *                 key?: scalar|null,
 *                 type?: scalar|null,
 *                 data?: scalar|null,
 *                 config?: scalar|null,
 *                 ctype?: scalar|null,
 *                 inheritable?: bool,
 *                 creationDate?: int,
 *                 modificationDate?: int,
 *             }>,
 *         },
 *         ...<mixed>
 *     },
 *     perspectives?: array{
 *         definitions?: list<array{ // Default: []
 *             iconCls?: scalar|null,
 *             icon?: scalar|null,
 *             toolbar?: mixed,
 *             dashboards?: array{
 *                 disabledPortlets?: mixed,
 *                 predefined?: mixed,
 *             },
 *             elementTree?: list<array{ // Default: []
 *                 type?: scalar|null,
 *                 position?: scalar|null,
 *                 name?: scalar|null,
 *                 expanded?: bool,
 *                 hidden?: scalar|null,
 *                 sort?: int,
 *                 id?: scalar|null,
 *                 treeContextMenu?: mixed,
 *             }>,
 *         }>,
 *         ...<mixed>
 *     },
 *     custom_views?: array{
 *         definitions?: list<array{ // Default: []
 *             id?: scalar|null,
 *             treetype?: scalar|null,
 *             name?: scalar|null,
 *             condition?: scalar|null,
 *             icon?: scalar|null,
 *             rootfolder?: scalar|null,
 *             showroot?: scalar|null,
 *             classes?: mixed,
 *             position?: scalar|null,
 *             sort?: scalar|null,
 *             expanded?: bool,
 *             having?: scalar|null,
 *             where?: scalar|null,
 *             treeContextMenu?: mixed,
 *             joins?: list<array{ // Default: []
 *                 type?: scalar|null,
 *                 condition?: scalar|null,
 *                 name?: mixed,
 *                 columns?: mixed,
 *             }>,
 *         }>,
 *         ...<mixed>
 *     },
 *     templating_engine?: array{
 *         twig?: array{
 *             sandbox_security_policy?: array{ // Allowlist tags, filters & functions for evaluating twig templates in a sandbox environment e.g. used by Mailer & Text layout component.
 *                 tags?: list<scalar|null>,
 *                 filters?: list<scalar|null>,
 *                 functions?: list<scalar|null>,
 *             },
 *         },
 *     },
 *     gotenberg?: array{
 *         base_url?: scalar|null, // Default: "http://gotenberg:3000"
 *         ping_cache_ttl?: scalar|null, // Default: 60
 *     },
 *     dependency?: array{
 *         enabled?: scalar|null, // Default: true
 *     },
 *     product_registration?: array{
 *         instance_identifier?: scalar|null, // Unique identifier of that Pimcore instance. Will be generated during install.
 *         product_key?: scalar|null, // Product registration key obtained during product registration. It is based on `instance_identifier` and `pimcore.encryption.secret`.
 *     },
 *     config_location?: array{
 *         image_thumbnails?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         video_thumbnails?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         document_types?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         predefined_properties?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         predefined_asset_metadata?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         perspectives?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         custom_views?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         object_custom_layouts?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *         },
 *         system_settings?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *             read_target?: array{
 *                 type?: "symfony-config"|"settings-store", // Default: null
 *                 options?: list<mixed>,
 *             },
 *         },
 *         select_options?: array{
 *             write_target?: array{
 *                 type?: "symfony-config"|"settings-store"|"disabled", // Default: "symfony-config"
 *                 options?: list<mixed>,
 *             },
 *             read_target?: array{
 *                 type?: "symfony-config"|"settings-store", // Default: null
 *                 options?: list<mixed>,
 *             },
 *         },
 *     },
 * }
 * @psalm-type ConfigType = array{
 *     imports?: ImportsConfig,
 *     parameters?: ParametersConfig,
 *     services?: ServicesConfig,
 *     core_shop_menu?: CoreShopMenuConfig,
 *     core_shop_pimcore?: CoreShopPimcoreConfig,
 *     framework?: FrameworkConfig,
 *     security?: SecurityConfig,
 *     twig?: TwigConfig,
 *     twig_extra?: TwigExtraConfig,
 *     monolog?: MonologConfig,
 *     doctrine?: DoctrineConfig,
 *     doctrine_migrations?: DoctrineMigrationsConfig,
 *     cmf_routing?: CmfRoutingConfig,
 *     scheb_two_factor?: SchebTwoFactorConfig,
 *     fos_js_routing?: FosJsRoutingConfig,
 *     flysystem?: FlysystemConfig,
 *     knp_paginator?: KnpPaginatorConfig,
 *     debug?: DebugConfig,
 *     web_profiler?: WebProfilerConfig,
 *     pimcore_admin?: PimcoreAdminConfig,
 *     pimcore_data_hub?: PimcoreDataHubConfig,
 *     webpack_encore?: WebpackEncoreConfig,
 *     pimcore_custom_reports?: PimcoreCustomReportsConfig,
 *     pimcore_glossary?: PimcoreGlossaryConfig,
 *     pimcore_seo?: PimcoreSeoConfig,
 *     presta_sitemap?: PrestaSitemapConfig,
 *     pimcore_static_routes?: PimcoreStaticRoutesConfig,
 *     pimcore_uuid?: PimcoreUuidConfig,
 *     pimcore_xliff?: PimcoreXliffConfig,
 *     pimcore_data_importer?: PimcoreDataImporterConfig,
 *     pimcore_perspective_editor?: PimcorePerspectiveEditorConfig,
 *     folder_creator?: FolderCreatorConfig,
 *     role_creator?: RoleCreatorConfig,
 *     core_shop_messenger?: CoreShopMessengerConfig,
 *     knp_menu?: KnpMenuConfig,
 *     object_layout_grid?: ObjectLayoutGridConfig,
 *     pimcore?: PimcoreConfig,
 *     ...<string, ExtensionType|array{ // extra keys must follow the when@%env% pattern or match an extension alias
 *         imports?: ImportsConfig,
 *         parameters?: ParametersConfig,
 *         services?: ServicesConfig,
 *         ...<string, ExtensionType>,
 *     }>
 * }
 */
final class App
{
    /**
     * @param ConfigType $config
     *
     * @psalm-return ConfigType
     */
    public static function config(array $config): array
    {
        return AppReference::config($config);
    }
}

namespace Symfony\Component\Routing\Loader\Configurator;

/**
 * This class provides array-shapes for configuring the routes of an application.
 *
 * Example:
 *
 *     ```php
 *     // config/routes.php
 *     namespace Symfony\Component\Routing\Loader\Configurator;
 *
 *     return Routes::config([
 *         'controllers' => [
 *             'resource' => 'routing.controllers',
 *         ],
 *     ]);
 *     ```
 *
 * @psalm-type RouteConfig = array{
 *     path: string|array<string,string>,
 *     controller?: string,
 *     methods?: string|list<string>,
 *     requirements?: array<string,string>,
 *     defaults?: array<string,mixed>,
 *     options?: array<string,mixed>,
 *     host?: string|array<string,string>,
 *     schemes?: string|list<string>,
 *     condition?: string,
 *     locale?: string,
 *     format?: string,
 *     utf8?: bool,
 *     stateless?: bool,
 * }
 * @psalm-type ImportConfig = array{
 *     resource: string,
 *     type?: string,
 *     exclude?: string|list<string>,
 *     prefix?: string|array<string,string>,
 *     name_prefix?: string,
 *     trailing_slash_on_root?: bool,
 *     controller?: string,
 *     methods?: string|list<string>,
 *     requirements?: array<string,string>,
 *     defaults?: array<string,mixed>,
 *     options?: array<string,mixed>,
 *     host?: string|array<string,string>,
 *     schemes?: string|list<string>,
 *     condition?: string,
 *     locale?: string,
 *     format?: string,
 *     utf8?: bool,
 *     stateless?: bool,
 * }
 * @psalm-type AliasConfig = array{
 *     alias: string,
 *     deprecated?: array{package:string, version:string, message?:string},
 * }
 * @psalm-type RoutesConfig = array{
 *     "when@dev"?: array<string, RouteConfig|ImportConfig|AliasConfig>,
 *     ...<string, RouteConfig|ImportConfig|AliasConfig>
 * }
 */
final class Routes
{
    /**
     * @param RoutesConfig $config
     *
     * @psalm-return RoutesConfig
     */
    public static function config(array $config): array
    {
        return $config;
    }
}
