#/bin/bash

version=$1
file_name=$2

if [[ -z "${version}" || -z "${file_name}" ]]; then 
    echo "Error: Version or file name missing!"
    exit 1 
fi
echo "${version}" > ${file_name}

git add ${file_name}
git commit -m "chore(version):- bump version to $NEW_VERSION [skip ci]"
git push origin HEAD:main