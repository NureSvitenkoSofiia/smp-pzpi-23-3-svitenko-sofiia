#!/bin/bash

convert_csv_data() {
    iconv -f cp1251 -t UTF-8 "$data_file"| tr '\r' '\n' | awk -F'","' -v group_arg="$group" '
    function format_time_to_ampm(time_string, temp_array, hrs, mins, period, formatted_output) {
        split(time_string, temp_array, ":");
        hrs = temp_array[1] + 0;
        mins = temp_array[2];
        
        period = (hrs >= 12) ? "PM" : "AM";
        hrs = (hrs % 12);
        if (hrs == 0) hrs = 12;
        
        formatted_output = (hrs < 10 ? "0" hrs : hrs) ":" mins " " period;
        
        return formatted_output;
    }

    {
        split($1, class_info, " ")
        if (class_info[1] ~ group_arg && (length(class_info[1]) - 1) == length(group_arg)) {
            course = substr($1, 2)
            sub("^" group_arg " - ", "", course)

            split($2, date_parts, ".");
            transformed_start_date = date_parts[2] "/" date_parts[1] "/" date_parts[3];

            split($4, date_parts, ".");
            transformed_end_date = date_parts[2] "/" date_parts[1] "/" date_parts[3];

            transformed_start_time = format_time_to_ampm($3)
            transformed_end_time = format_time_to_ampm($5)
            
            print course "+" transformed_start_date "+" transformed_start_time "+" transformed_end_date "+" transformed_end_time "+" $12
        }
    }' | sort -t"+" -k1,1 -k2,2 | awk -F'+' -v last_subj="$last_subj" -v item_num="$item_num" -v lab_seq="$lab_seq" '
    {
        if(NR == 1){
            print("Subject,Start Date,Start Time,End Date,End Time,Description");
        }
        if($1 == last_subj){
            if($1 ~ "Лб"){
                if(lab_seq % 2 == 1){
                    print($1 "; №" item_num "," $2 "," $3 "," $4 "," $5 "," $6)
                } else {
                    item_num += 1
                    print($1 "; №" item_num "," $2 "," $3 "," $4 "," $5 "," $6)
                }
                lab_seq += 1
            } else {
                item_num += 1
                print($1 "; №" item_num "," $2 "," $3 "," $4 "," $5 "," $6)
            }
        } else {
            lab_seq = 1
            item_num = 1
            print($1 "; №" item_num "," $2 "," $3 "," $4 "," $5 "," $6)
        }
        last_subj = $1
    }'
}

print_version() {
    echo "task2 version 1.0.0"
}

show_manual() {
    echo "Використання: {login_name}-task2 [--help | --version] | [[-q|--quiet] [group] [timetable_file.csv]"
    echo
    echo "Параметри:"
    echo "  --help           Показати опис"
    echo "  --version        Показати версію скрипта"
    echo "  -q, --quiet      Не виводити інформацію на екран"
    echo "  timetable_file.csv    Шлях до CSV файлу (Необов'язково)"
    echo "  group            Академічна група (Необов'язково)"
}

select_timetable_file() {
    if [[ -z "$data_file" ]]; then
        pattern="TimeTable_??_??_20??.csv"

        available_files=($(ls -1t $pattern))

        if [[ ${#available_files[@]} -eq 0 ]]; then
            echo "Не знайдено файлів за шаблоном: $pattern"
            exit 1
        fi

        echo "Оберіть файл:"
        select selected_file in "${available_files[@]}"; do
            if [[ -n "$selected_file" ]]; then
                echo "Ви обрали: $selected_file"
                data_file=$selected_file
                break
            else
                echo "Неправильний вибір, спробуйте ще раз"
            fi
        done
    fi

    if [ ! -e "$data_file" ]; then
        echo "Файл не існує"
        exit 1
    fi

    if [ ! -r "$data_file" ]; then
        echo "Файл недоступний для читання"
        exit 1
    fi
}

determine_student_group() {
    available_units=($(iconv -f cp1251 -t UTF-8 "$data_file"| tr '\r' '\n' | awk -F',' 'NR > 1 {print substr($1,2,10)}' | sort | uniq))

    if [[ -z "$group" && ${#available_units[@]} -eq 1 ]]; then
        group=${available_units[0]}
        echo "Знайдено лише одну групу: $group. Використовуємо цю групу."
    elif [[ -z "$group" ]]; then
        echo "Оберіть групу:"
        select option in ${available_units[@]}; do
            if [[ -n "$option" ]]; then
                group=$option
                break
            else
                echo "Неправильний вибір, спробуйте ще раз"
            fi
        done
    elif [[ ! " ${available_units[*]} " =~ " ${group} " ]]; then
        echo "Вказана група не знайдена у файлі, оберіть іншу: "
        select option in ${available_units[@]}; do
            if [[ -n "$option" ]]; then
                group=$option
                break
            else
                echo "Неправильний вибір, спробуйте ще раз"
            fi
        done
    fi
}

silent=false

if [[ "$1" == "--help" ]]; then
    show_manual
    exit 0
elif [[ "$1" == "--version" ]]; then
    print_version
    exit 0
elif [[ "$1" == "-q" || "$1" == "--quiet" ]]; then
    silent=true
    shift
fi

if [[ $# -eq 1 ]]; then
    data_file="$1"
    group=""
elif [[ $# -eq 2 ]]; then
    group="$1"
    data_file="$2"
else
    group=""
    data_file=""
fi

select_timetable_file
determine_student_group

result_file="Google_${data_file}"

if [[ "$silent" == true ]]; then
    convert_csv_data >"$result_file"
    exit_code=$?
else
    convert_csv_data | tee "$result_file"
    exit_code=${PIPESTATUS[0]}
fi

if [[ $exit_code -ne 0 ]]; then
    echo "Помилка під час обробки файлу"
    exit 2
fi

echo "Файл успішно оброблено та збережено як $result_file"
exit 0