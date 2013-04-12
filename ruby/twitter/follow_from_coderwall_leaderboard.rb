require File.expand_path('../boot', __FILE__)

SITE_URL = 'https://coderwall.com/leaderboard'

agent = Mechanize.new

users = []
agent.get(SITE_URL).search('div.team a:first-child').each do |a|
  agent.get(a['href']).search('div.member-details').each do |div|
    users << div.at('a.view-profile')['href'].delete('/')
  end
end

users.each do |u|
  begin
    Twitter.follow(u)
    puts u
  rescue Twitter::Error::NotFound
    puts "#{u} is not found"
  end
end
