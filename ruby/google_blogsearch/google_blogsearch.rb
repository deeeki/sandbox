# coding: utf-8
require 'cgi'
require 'open-uri'
require 'active_support/core_ext/object'
require 'hashie/mash'

module Google
  class BlogSearch
    ENDPOINT = 'http://blogsearch.google.co.jp/blogsearch_feeds'
    OPTIONS = {
      :q => '',
      :num => 10,
      :ie => 'utf-8',
      :hl => 'ja',
      :lr => 'lang_ja',
      :output => 'rss',
    }

    class << self
      def search(keyword, options = {})
        params = OPTIONS.merge(options).merge(:q => keyword)
        feed = open(build_url(params)).read
        hash = parse_xml(feed)
        convert(hash)
      end

      def build_url(params = {})
        raise ArgumentError, 'Argument must be a Hash object' unless params.is_a?(Hash)
        params_str = params.map{|k,v| k.to_s + '=' + CGI.escape(v.to_s) }.join('&')
        ENDPOINT + '?' + params_str
      end

      private
      def parse_xml(xml)
        xml.encode!('UTF-8') #fix: invalid byte sequence in UTF-8 (ArgumentError)
        Hash.from_xml xml
      end

      def convert(hash)
        begin
          hash['rss']['channel']['item'].map do |i|
            Hashie::Mash.new(i)
          end
        rescue => e
          nil
        end
      end
    end
  end
end
