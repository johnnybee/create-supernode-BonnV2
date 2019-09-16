arr=()
mapfile -t arr <<< $(wg show wg0 | grep peer | awk '{print $2}')
for i in "${arr[@]}"
do
        wg set wg0 peer $i remove
done
