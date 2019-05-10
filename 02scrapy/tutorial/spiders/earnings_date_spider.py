import scrapy


class edSpider(scrapy.Spider):
    name = 'ed_spider'

    def __init__(self, stock_list=None, *args, **kwargs):
        super(edSpider, self).__init__(*args, **kwargs)
        self.start_urls = ['https://www.nasdaq.com/earnings/report/' + ticker \
                           for ticker in stock_list.strip(',').split(',')]

    def parse(self, response):
        earnings_date_str = response.xpath('//*[@id="left-column-div"]/h2/text()').get()
        yield {
            'earnings date': earnings_date_str.strip(),
        }

# terminal command
# rm earnings_date.json; scrapy crawl ed_spider -o earnings_date.json -a stock_list='amd,dis,dal,bili,mu,wba,vz,bidu,bac'
