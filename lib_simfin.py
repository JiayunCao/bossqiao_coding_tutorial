import pandas as pd
import requests
import requests_cache

global api_key,sim_id_dict,stock_price_dict
api_key = "rLvevB5Qhi5Ruu8Yab6zNzwdZ2Nu98cA"
stock_price_dict={}
sim_id_dict={}

#86400 seconds = 24 hours
requests_cache.install_cache('simfin_cache', backend='sqlite', expire_after=86400)


# build sim_id_dict
#https://simfin.com/api/v1/info/find-id/ticker/amd?api-key=rLvevB5Qhi5Ruu8Yab6zNzwdZ2Nu98cA
def sim_id_map(tickers):
    global sim_id_dict, api_key
    
    for ticker in tickers:
        request_url = f'https://simfin.com/api/v1/info/find-id/ticker/{ticker}?api-key={api_key}'
        content = requests.get(request_url)
        data = content.json()
        #print(data)
        if "error" in data or len(data) < 1:
            print("price data empty, 检查ticker是否拼错")
        else:
            sim_id_dict[data[0]['ticker']] = data[0]['simId']



#get stock price history
def get_price_info(tickers):
    global sim_id_dict, api_key, stock_price_dict

    for ticker in tickers:
        companyId = sim_id_dict[ticker]
        request_url = f'https://simfin.com/api/v1/companies/id/{companyId}/shares/prices?api-key={api_key}'
        price_content = requests.get(request_url)
        price_data = price_content.json()

        stock_price = pd.DataFrame(price_data['priceData'])
        stock_price["closeAdj"] = pd.to_numeric(stock_price["closeAdj"])
        stock_price = stock_price[["date", "closeAdj"]]
        stock_price_dict[ticker]=stock_price


def get_price_date(ticker, date):
    try:
        df = stock_price_dict[ticker]
        return df[df['date']==date].iloc[0,1]
    except:
        print('no price info for ', ticker, date)


#days=10代表过去10天的股价涨跌幅
def price_chg(ticker, days):
    global stock_price_dict
    price_now = stock_price_dict[ticker].iloc[0,1]
    try:
        price_past = stock_price_dict[ticker].iloc[days-1,1]
        price_chg = (price_now - price_past)/price_past
        price_chg = '%.1f%%' % (price_chg*100)
    except:
        price_chg = "N/A"
    return price_chg


def price_chg_date(ticker, start_date, end_date):
    start_price = get_price_date(ticker, start_date)
    end_price = get_price_date(ticker, end_date)
    
    if((start_price is not None) and (end_price is not None)):
        price_chg = (end_price - start_price)/start_price
        price_chg = '%.1f%%' % (price_chg*100)
    else:
        price_chg = "N/A"
    return price_chg


def show_momentum(tickers, periods):
    momentum = {}
    for ticker in tickers:
        list = []
        for period in periods:
            list.append(price_chg(ticker, period))
        momentum[ticker]=list

    df_m = pd.DataFrame(momentum, index=periods)
    return df_m


def show_momentum_date(tickers, start_date, end_date):
    momentum = {}
    for ticker in tickers:
        momentum[ticker] = price_chg_date(ticker, start_date, end_date)
    df_m = pd.DataFrame(momentum, index=['%s%s%s' % (start_date, ' ~ ', end_date)])
    return df_m

'''
tickers = ["AMD","NVDA","INTC"]
sim_id_map(tickers)

get_price_info(tickers)
stock_price_dict['AMD'].head(10)

ticker = "AMD"
days = 100
print(price_chg(ticker, days))

periods = [5, 10, 30, 50, 100, 200, 300, 1000]
show_momentum(tickers, periods)

df1 = show_momentum_date(tickers, '2019-01-02', '2019-03-22')
df2 = show_momentum_date(tickers, '2018-01-02', '2019-03-22')
df3 = show_momentum_date(tickers, '2017-01-03', '2019-03-22')
pd.concat([df1, df2, df3])
'''


