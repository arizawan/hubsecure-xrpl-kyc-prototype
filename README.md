
# HubSecure XRPL internal API

This API helps hubsecure to Upload/Download files, Encrypt/Decrypt Files and Create Encrypted NFT inside XRPL.

## Postman Collection

Can be found in `postman_collection` Import it to your postman and set host.

## What This API does not handle?

* Any User Data
* Any Unencrypted files in local storage
* Host Customers XRPL Wallet data [Seed, Sequence]
* Host Encryption / Decryption key

## What This API does?

* Handle File Uploads and Provide UUID called `document_uuid`
* Handle File Upload to IPFS
* Handle Temporary file deletions
* Handle File Compression and Encryption
* Handle Encryption key generation and Securing Encryption key in NFT 
* Handle NFT minting in XRPL 

## Required Inputs 

* `app_encryption_key` Is Global Application encryption key, that needs to be provided from `HubSecure Main Backend`
* `client_encryption_key` Is Uniqe Set of Sentences that is generated for every Customer and stored in `HubSecure Main Backend`
* `client_wallet_seed` Is Customers XRPL Wallet seed that will be generated with This API But will be stored and provided from `HubSecure Main Backend`
* `client_wallet_seq` : Is Customers XRPL Wallet Sequence that will be generated with This API But will be stored and provided from `HubSecure Main Backend`
* `document_uuid` Will be provided from this API when uploading new file. This needs to be stored and provided from `HubSecure Main Backend` for future requests.

## Defaults

```
{
    "application" : {
        "app_encryption_key" : "SaOMTDoNigGV//4yirHCQUNDktGqW86+"
    },
    "client" : {
        "client_encryption_key" : "GHIM KLUORDS MCDOOTTS THRANT SCHLOEB",
        "client_wallet_seed" : "sEdTsxgEsgatzanLPKA6vJcTeFwSom2",
        "client_wallet_seq" : "36191320"
    }
}
```

## Default XRP Client Wallet

```
https://testnet.xrpl.org/accounts/rGnMFAFQaWJerxGpUsjoHZRB4nF2RvbQJo
```

## Default XRPL API IP

```
http://139.162.148.222:8005
```

## Video How To :

[![XRPL API Usage How To](https://img.youtube.com/vi/b4HATqEIL2Y/0.jpg)](https://www.youtube.com/watch?v=b4HATqEIL2Y)