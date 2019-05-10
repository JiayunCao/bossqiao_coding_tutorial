import json
import pandas as pd
from datetime import datetime

def earnings_date(filename):
    ticker_date = {}
    with open(filename, 'r') as f:
        temp = json.loads(f.read())
        for item in temp:
            line = item['earnings date']
            ticker = line[line.find('for ')+4:line.find(':')]
            earnings_date = line[line.find(':')+2:]
            if len(earnings_date) < 5:
                earnings_date = datetime.strptime('Jan 1, 9021', '%b %d, %Y')
            else:
                earnings_date = datetime.strptime(earnings_date, '%b %d, %Y')
            ticker_date[ticker] = earnings_date
    ticker_date = sorted(ticker_date.items(), key=lambda p: p[1], reverse=False)
    earnings_date_df = pd.DataFrame(ticker_date, columns=['ticker', 'earnings_date'])
    earnings_date_df['earnings_date'] = earnings_date_df['earnings_date'].apply(lambda x: x.date())
    return earnings_date_df

df = earnings_date("02scrapy/earnings_date.json")
