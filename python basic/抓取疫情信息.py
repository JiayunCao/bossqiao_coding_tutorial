# reference: https://github.com/Programming-With-Love/2019-nCoV/blob/master/2019-nCov.py
# 疫情统计数据保存到 'files/' 文件夹下的两个文件中
import requests
import time
import json
from prettytable import ALL
from prettytable import PrettyTable

timestamp = 0  #全局变量时间戳，用于记录疫情数据的更新时间，以此判断是否有新的数据

def get_yiqing_stat(table, table_by_province):
    url = "https://service-f9fjwngp-1252021671.bj.apigw.tencentcs.com/release/pneumonia"
    global timestamp
    
    try:
        # 获取json格式的疫情数据
        r = requests.get(url)
        json_str = json.loads(r.text)
        publish_time = json_str['data']['statistics']['modifyTime']
        if publish_time == timestamp:
            print('数据未更新，时间戳：',publish_time)
            return 0
        else:
            timestamp = publish_time
        publish_time_formatted = time.strftime("%m-%d %H:%M", time.localtime(publish_time/1000))#转换时间格式
        confirmed = json_str['data']['statistics']['confirmedCount']
        suspected = json_str['data']['statistics']['suspectedCount']
        dead = json_str['data']['statistics']['deadCount']
        cured = json_str['data']['statistics']['curedCount']
        
        #建立表格并存入数据
        table.add_row([publish_time_formatted, confirmed, suspected, dead, cured])
        print("\n-------全国汇总数据---------",publish_time_formatted)
        print(table)

        
        print("\n-------分省份数据（仅统计确诊病例）---------\n")
        temp_row = {'发布时间':publish_time_formatted,'湖北':1,'浙江':2,'广东':3,'河南':4}
        data_by_province = json_str['data']['listByArea']
        for province_data in data_by_province:
            if province_data['provinceShortName'] in ["湖北","浙江","广东","河南"]:
                temp_row[province_data['provinceShortName']] = province_data['confirmed']
        #print(temp_row)
        table_by_province.add_row([temp_row['发布时间'],temp_row['湖北'],temp_row['浙江'],\
                                   temp_row['广东'],temp_row['河南']])
        print(table_by_province)
        return True
        
    except:
        print("出错啦")


# 将prettytable保存到csv文件中        
def ptable_to_csv(table, filename, headers=True):
    """Save PrettyTable results to a CSV file.

    Adapted from @AdamSmith https://stackoverflow.com/questions/32128226

    :param PrettyTable table: Table object to get data from.
    :param str filename: Filepath for the output CSV.
    :param bool headers: Whether to include the header row in the CSV.
    :return: None
    """
    raw = table.get_string()
    data = [tuple(filter(None, map(str.strip, splitline)))
            for line in raw.splitlines()
            for splitline in [line.split('|')] if len(splitline) > 1]
    if not headers:
        data = data[1:]
    with open(filename, 'w') as f:
        for d in data:
            f.write('{}\n'.format(','.join(d)))        

            
def main():
    table = PrettyTable(['发布时间','确诊','疑似', '死亡', '治愈'])
    table_by_province = PrettyTable(['发布时间','湖北','浙江','广东','河南'])
    while True:
        get_yiqing_stat(table, table_by_province)
        ptable_to_csv(table, 'files/全国疫情统计.csv', headers=True)
        ptable_to_csv(table_by_province, 'files/分省疫情统计.csv', headers=True)
        time.sleep(1800) #抓取一次数据的间隔，单位为秒
    print('program ended')


main()