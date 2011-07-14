# coding: utf-8
require 'open-uri'
require 'json'
require 'rss'

#rss is already exists. http://www.zusaar.com/index.rss
ZUSAAR_API = 'http://www.zusaar.com/api/event/'
ZUSAAR_URL = 'http://www.zusaar.com/event/search/'

json = JSON.parse(URI.parse(ZUSAAR_API).read)

ENV['HTTP_HOST'] = 'example.com' if ENV['HTTP_HOST'].nil?
ENV['REQUEST_URI'] = '/' if ENV['REQUEST_URI'].nil?

rss = RSS::Maker.make('1.0') do |maker|
	maker.channel.about = 'http://' + ENV['HTTP_HOST'] + ENV['REQUEST_URI']
	maker.channel.title = 'Zusaar 新着イベント'
	maker.channel.description = 'Zusaar 新着イベント'
	maker.channel.link = ZUSAAR_URL

	json['event'].each do |e|
		maker.items.new_item do |item|
			item.id = e['event_id']
			item.link = e['event_url']
			item.title = e['title']
			item.description = e['description']
			item.author = e['owner_nickname']
			item.date = e['updated_at']
		end
	end
end
print rss
