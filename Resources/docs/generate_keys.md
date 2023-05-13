### Generate keys 🤔 ?
1. <a href="https://lcobucci-jwt.readthedocs.io/en/latest/supported-algorithms/" target="_blank">Supported algorithms</a>
2. Choose <a href="https://www.rfc-editor.org/rfc/rfc7518#section-3.1" target="_blank">algorithm</a>
3. Generate **private** key:

#### `ES256`, `ES384`, `ES512`:
```shell
openssl genpkey \
-out ./private.pem \
-algorithm EC \
-pkeyopt ec_paramgen_curve:prime256v1 \
-aes-256-cbc \
-pass pass:${APP_SECRET}

```

#### `RS256`, `RS384`, `RS512`:
```shell
openssl genpkey \
-out ./private.pem \
-algorithm RSA \
-pkeyopt rsa_keygen_bits:4096 \
-aes-256-cbc \
-pass pass:${APP_SECRET}
```

4. Extract **public** key in private key:
```shell
openssl pkey \
-in private.pem \
-passin pass:${APP_SECRET} \
-out public.pem \
-pubout
```

<a href="https://www.feistyduck.com/library/openssl-cookbook/online/openssl-command-line/key-generation.html" target="_blank">OpenSSL Cookbook</a>
