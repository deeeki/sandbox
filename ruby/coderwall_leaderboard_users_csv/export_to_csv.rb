require 'bundler/setup'
Bundler.require(:default) if defined?(Bundler)

SITE_URL = 'https://coderwall.com/leaderboard'

a = Mechanize.new
rows = ['team,name,username']
a.get(SITE_URL).search('div.team a:first-child').each do |l|
  team = l.text.strip
  a.get(l['href']).search('div.member-details').each do |div|
    cols = [
      team,
      div.at('h3').text.strip,
      div.at('a.view-profile')['href'].delete('/'),
    ]
    rows << %["#{cols.join('","')}"]
  end
end

File.write('leaderboard_users.csv', rows.join("\n"))
