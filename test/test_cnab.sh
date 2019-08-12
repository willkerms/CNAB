#!/bin/bash
DIR=$(readlink -f $0)
DIR=$(dirname $DIR)"/"
CNAB_CLI=$DIR"index.php"

php $CNAB_CLI
