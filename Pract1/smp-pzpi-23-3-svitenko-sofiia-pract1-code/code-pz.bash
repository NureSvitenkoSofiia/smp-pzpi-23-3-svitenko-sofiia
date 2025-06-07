#!/bin/bash
ht=$1
ws=$2

if [ $# -eq 0 ]; then
  echo "немає аргументів" >&2
  exit 1
fi

if (( ht % 2 != 0 )); then
  ht=$(($ht - 1))
fi

if (( $ws % 2 == 0 )); then
  ws=$(($ws - 1))
fi

printBase(){
  spaceCount=$((($ws - 3)/2))
  i=0
  padding=""

  while [ $i -ne $spaceCount ]; do
      padding="$padding " 
      i=$((i + 1))
  done

  brackets='###'
  for i in {0,1}; do
      echo "$padding$brackets"
  done
}

printBottom(){
  i=0
  cur=""
  until [ $i -eq $(($ws)) ]; do
      cur="$cur*"
      i=$((i + 1))
  done

  echo "$cur"
}

if [[ $ht -le 0 || $ws -le 0 ]]; then
  echo "повинні бути позитивні значення" >&2
  exit 2
fi

if [[ $ht -le 7 ]]; then
  echo "висота має бути більша за 7" >&2
  exit 3
fi

if [ $ws -ne $(($ht - 1)) ]; then
  echo "за таких умов неможливо побудувати ялинку" >&2
  exit 4
fi

sectionHeight=$(( ($ht - 3) / 2 + 1))
treeSymbol='*'
symbW=1

for (( sectIndex=0; sectIndex < 2; sectIndex++ )); do
    for (( rowIndex=0; rowIndex < $sectionHeight; rowIndex++ )); do
        paddingWidth=$(( ($ws - $symbW) / 2 ))
        padding=""

        for (( padIndex=0; padIndex < $paddingWidth; padIndex++ )); do
            padding+=" "
        done
        
        treeRow=""
        for (( symIndex=0; symIndex < $symbW; symIndex++ )); do
            treeRow+="$treeSymbol"
        done
        
        echo "$padding$treeRow"
        
        symbW=$(( $symbW + 2 ))
        
        if [[ $treeSymbol == "#" ]]; then
            treeSymbol='*'
        else 
            treeSymbol='#'
        fi
    done
    sectionHeight=$((sectionHeight - 1))
    symbW=3

done

printBase
printBottom