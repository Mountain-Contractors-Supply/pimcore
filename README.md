# MLS Pimcore

Forked from https://github.com/TorqIT/pimcore-skeleton.

## Setup

### Prerequisites:

-   A Linux based system (or Windows Subsystem for Linux (WSL) if you are on Windows - see https://learn.microsoft.com/en-us/windows/wsl/install for more information)
-   Docker Desktop (https://www.docker.com/products/docker-desktop/)

### Setup instructions

1. Clone the repository and all submodules (`git clone --recursive https://github.com/Mountain-Contractors-Supply/pimcore`)
1. Under the `.secrets` directory:
    1. Create a file called `kernel-secret` and add a random 32-character string to it.
    1. Create a file called `pimcore-product-key` and add your Pimcore product key to it.
    1. Create a file called `pimcore-instance-identifier` and add your Pimcore instance ID to it.
    1. Create a file called `pimcore-encryption-secret` and add an encryption secret to it generated using https://github.com/defuse/php-encryption.
    1. Do NOT commit any of the files in this directory to your repository (they should already be gitignored).
1. Copy a supplied .env.local to the root of this project
1. Run `docker compose up -d` to build the Docker images and run the containers
1. Restore an up to date version of the database
1. From within the php container (`docker compose exec --user www-data -it php bash -l`) or docker exec, run `bin/console assets:install public --symlink`
1. From within the php container (`docker compose exec --user www-data -it php bash -l`) or docker exec, run `bin/console importmap:install`
1. From within the php container (`docker compose exec --user www-data -it php bash -l`) or docker exec, run `bin/console asset-map:compile`
1. Go to `localhost:8415` in your browser to access the Pimcore admin (port is controlled by the `WEB_EXTERNAL_PORT` environment variable). Use username `admin` and password `pimcore` to log in.

## Getting updates from skeleton

1. If using SSH for Git, run `git remote add upstream git@github.com:TorqIT/pimcore-skeleton.git`; otherwise, run `git remote add upstream https://github.com/TorqIT/pimcore-skeleton.git`
1. To fetch and merge updates from the skeleton, run `git fetch upstream`, then `git merge upstream/<branch name>`, defining the branch you want to pull from (e.g. `2025.x`).
