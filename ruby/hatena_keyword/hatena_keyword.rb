# coding: utf-8
require 'cgi'
require 'open-uri'
require 'active_support/core_ext/object'
require 'hashie/mash'

module Hatena
  class Keyword
    ENDPOINT = 'http://d.hatena.ne.jp/keyword'
    OPTIONS = {
      :word => '',
      :ie => 'utf-8',
      :mode => 'rss',
    }

    class << self
      def get(keyword, options = {})
        params = OPTIONS.merge(options).merge(:word => keyword)
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
        Hash.from_xml xml
      end

      def convert(hash)
        begin
          Hashie::Mash.new(hash['RDF']['item'])
        rescue => e
          nil
        end
      end
    end
  end
end
