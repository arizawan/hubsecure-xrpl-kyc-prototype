# HubSecure Team (KYC prototype)

[![Hubsecure Team](https://img.youtube.com/vi/ymRMJo8ZDQs/0.jpg)](https://www.youtube.com/watch?v=ymRMJo8ZDQs)

# Demo

[![Hubsecure KYC Demo](https://img.youtube.com/vi/znTvWGfGfAc/0.jpg)](https://www.youtube.com/watch?v=znTvWGfGfAc)


# Deployment

#### Note

* Change .env files as required on each app.

```sh
$ chmod +x *.sh
$ ./deploy.sh
```

# xrpl_api

This API helps to Upload/Download files, Encrypt/Decrypt Files and Create Encrypted NFT inside XRPL.

#### What This API does not handle?

* Any User Data
* Any Unencrypted files in local storage
* Host Customers XRPL Wallet data [Seed, Sequence]
* Host Encryption / Decryption key

#### What This API does?

* Handles File Uploads and Provide UUID called `document_uuid`
* Handles File Upload to IPFS
* Handles Temporary file deletions
* Handles File Compression and Encryption
* Handles Encryption key generation and Securing Encryption key in NFT 
* Handles NFT minting in XRPL 
* Handles KYC document verification using [https://www.idanalyzer.com] api.
* Handles KYC document encryption and NFT minting.

# kyc_app

* A simple interface to register users
* Users can Upload their KYC documents
* Users can Verify their KYC Document
* Users can mint NFT of KYC Verified Documents